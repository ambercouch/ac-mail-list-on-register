<?php

declare (strict_types=1);
namespace ACSB\Vendor\PhpParser\Node\Expr\Cast;

use ACSB\Vendor\PhpParser\Node\Expr\Cast;
class Unset_ extends Cast
{
    public function getType(): string
    {
        return 'Expr_Cast_Unset';
    }
}
