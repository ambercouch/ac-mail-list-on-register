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
namespace ACSB\Vendor\Humbug\PhpScoper\PhpParser\NodeVisitor\UseStmt;

use ACSB\Vendor\Humbug\PhpScoper\PhpParser\NodeVisitor\NamespaceStmt\NamespaceStmtCollection;
use ACSB\Vendor\PhpParser\Node;
use ACSB\Vendor\PhpParser\Node\Stmt\Use_;
use ACSB\Vendor\PhpParser\NodeVisitorAbstract;
/**
 * Collects all the use statements. This allows us to resolve a class/constant/function call into a fully-qualified
 * call.
 *
 * @private
 */
final class UseStmtCollector extends NodeVisitorAbstract
{
    public function __construct(private readonly NamespaceStmtCollection $namespaceStatements, private readonly UseStmtCollection $useStatements)
    {
    }
    public function enterNode(Node $node): Node
    {
        if ($node instanceof Use_) {
            $namespaceName = $this->namespaceStatements->getCurrentNamespaceName();
            $this->useStatements->add($namespaceName, $node);
        }
        return $node;
    }
}
