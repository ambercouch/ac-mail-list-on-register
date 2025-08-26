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
namespace ACSB\Vendor\Humbug\PhpScoper\PhpParser\Printer;

use ACSB\Vendor\PhpParser\PhpVersion;
use ACSB\Vendor\PhpParser\PrettyPrinter\Standard;
final class StandardPrinterFactory implements PrinterFactory
{
    public function createPrinter(?PhpVersion $phpVersion = null): Printer
    {
        return new StandardPrinter(new Standard(['phpVersion' => $phpVersion ?? PhpVersion::fromComponents(7, 2)]));
    }
}
