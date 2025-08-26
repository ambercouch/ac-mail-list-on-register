<?php

declare (strict_types=1);
namespace ACSB\Vendor\PhpParser\Node\Expr\BinaryOp;

use ACSB\Vendor\PhpParser\Node\Expr\BinaryOp;
class Identical extends BinaryOp
{
    public function getOperatorSigil(): string
    {
        return '===';
    }
    public function getType(): string
    {
        return 'Expr_BinaryOp_Identical';
    }
}
