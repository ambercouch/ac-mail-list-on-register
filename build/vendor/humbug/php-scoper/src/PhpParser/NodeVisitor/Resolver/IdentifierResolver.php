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
namespace ACSB\Vendor\Humbug\PhpScoper\PhpParser\NodeVisitor\Resolver;

use ACSB\Vendor\Humbug\PhpScoper\PhpParser\Node\NamedIdentifier;
use ACSB\Vendor\Humbug\PhpScoper\PhpParser\NodeVisitor\AttributeAppender\ParentNodeAppender;
use ACSB\Vendor\PhpParser\Node\Identifier;
use ACSB\Vendor\PhpParser\Node\Name;
use ACSB\Vendor\PhpParser\Node\Name\FullyQualified;
use ACSB\Vendor\PhpParser\Node\Scalar\String_;
use ACSB\Vendor\PhpParser\Node\Stmt\Function_;
use ACSB\Vendor\PhpParser\NodeVisitor\NameResolver;
use function array_filter;
use function implode;
use function ltrim;
/**
 * Attempts to resolve the identifier node into a fully qualified node. Returns a valid
 * (non fully-qualified) name node on failure.
 *
 * @private
 */
final readonly class IdentifierResolver
{
    public function __construct(private NameResolver $nameResolver)
    {
    }
    public function resolveIdentifier(Identifier $identifier): Name
    {
        $resolvedName = $identifier->getAttribute('resolvedName');
        if (null !== $resolvedName) {
            return $resolvedName;
        }
        $parentNode = ParentNodeAppender::getParent($identifier);
        if ($parentNode instanceof Function_) {
            return $this->resolveFunctionIdentifier($identifier);
        }
        $name = NamedIdentifier::create($identifier);
        return $this->nameResolver->getNameContext()->getResolvedClassName($name);
    }
    public function resolveString(String_ $string): Name
    {
        $name = new FullyQualified(ltrim($string->value, '\\'), $string->getAttributes());
        return $this->nameResolver->getNameContext()->getResolvedClassName($name);
    }
    private function resolveFunctionIdentifier(Identifier $identifier): Name
    {
        $nameParts = array_filter([$this->nameResolver->getNameContext()->getNamespace(), $identifier->toString()]);
        return new FullyQualified(implode('\\', $nameParts), $identifier->getAttributes());
    }
}
