<?php

declare (strict_types=1);
namespace ACSB\Vendor\PhpParser\Node\Expr\AssignOp;

use ACSB\Vendor\PhpParser\Node\Expr\AssignOp;
class BitwiseOr extends AssignOp
{
    public function getType(): string
    {
        return 'Expr_AssignOp_BitwiseOr';
    }
}
