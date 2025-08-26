<?php

declare (strict_types=1);
/*
 * This file is part of the humbug/php-scoper package.
 *
 * Copyright (c) 2017 Théo FIDRY <theo.fidry@gmail.com>,
 *                    Pádraic Brady <padraic.brady@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ACSB\Vendor\Humbug\PhpScoper\PhpParser\NodeVisitor;

use ACSB\Vendor\Humbug\PhpScoper\PhpParser\NodeVisitor\Resolver\IdentifierResolver;
use ACSB\Vendor\Humbug\PhpScoper\Symbol\EnrichedReflector;
use ACSB\Vendor\PhpParser\Node;
use ACSB\Vendor\PhpParser\Node\Arg;
use ACSB\Vendor\PhpParser\Node\Expr;
use ACSB\Vendor\PhpParser\Node\Expr\FuncCall;
use ACSB\Vendor\PhpParser\Node\Name\FullyQualified;
use ACSB\Vendor\PhpParser\Node\Scalar\String_;
use ACSB\Vendor\PhpParser\Node\Stmt\Const_;
use ACSB\Vendor\PhpParser\Node\Stmt\Expression;
use ACSB\Vendor\PhpParser\NodeVisitorAbstract;
use UnexpectedValueException;
use function count;
/**
 * Replaces constants `const` declarations by `define` for exposed constants.
 *
 * ```
 * const DUMMY_CONST = 'foo';
 * ```
 *
 * =>
 *
 * ```
 * define('DUMMY_CONST', 'foo');
 * ```
 *
 * @private
 */
final class ConstStmtReplacer extends NodeVisitorAbstract
{
    public function __construct(private readonly IdentifierResolver $identifierResolver, private readonly EnrichedReflector $enrichedReflector)
    {
    }
    public function enterNode(Node $node): Node
    {
        if (!$node instanceof Const_) {
            return $node;
        }
        foreach ($node->consts as $constant) {
            $replacement = $this->replaceConst($node, $constant);
            if (null !== $replacement) {
                // If there is more than one constant declare in the node we
                // will not have a replacement (this case is not supported)
                // hence the return statement is safe here.
                return $replacement;
            }
        }
        return $node;
    }
    private function replaceConst(Const_ $const, Node\Const_ $constant): ?Node
    {
        $resolvedConstantName = $this->identifierResolver->resolveIdentifier($constant->name);
        if (!$this->enrichedReflector->isExposedConstant((string) $resolvedConstantName)) {
            // No replacement
            return null;
        }
        if (count($const->consts) > 1) {
            // TODO: add support for this case instead of bailing out.
            throw new UnexpectedValueException('Exposing a constant declared in a grouped constant statement (e.g. `const FOO = \'foo\', BAR = \'bar\'; is not supported. Consider breaking it down in multiple constant declaration statements');
        }
        return self::createConstDefineNode((string) $resolvedConstantName, $constant->value);
    }
    private static function createConstDefineNode(string $name, Expr $value): Node
    {
        return new Expression(new FuncCall(new FullyQualified('define'), [new Arg(new String_($name)), new Arg($value)]));
    }
}
