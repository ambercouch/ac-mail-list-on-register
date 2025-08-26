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

use ACSB\Vendor\Humbug\PhpScoper\PhpParser\NodeVisitor\AttributeAppender\ParentNodeAppender;
use ACSB\Vendor\Humbug\PhpScoper\PhpParser\StringNodePrefixer;
use ACSB\Vendor\PhpParser\Node;
use ACSB\Vendor\PhpParser\Node\Expr\Eval_;
use ACSB\Vendor\PhpParser\Node\Scalar\String_;
use ACSB\Vendor\PhpParser\NodeVisitorAbstract;
final class EvalPrefixer extends NodeVisitorAbstract
{
    public function __construct(private readonly StringNodePrefixer $stringPrefixer)
    {
    }
    public function enterNode(Node $node): Node
    {
        if ($node instanceof String_ && ParentNodeAppender::findParent($node) instanceof Eval_) {
            $this->stringPrefixer->prefixStringValue($node);
        }
        return $node;
    }
}
