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
namespace ACSB\Vendor\Humbug\PhpScoper\Scoper\Factory;

use ACSB\Vendor\Humbug\PhpScoper\Configuration\Configuration;
use ACSB\Vendor\Humbug\PhpScoper\Scoper\Scoper;
use ACSB\Vendor\Humbug\PhpScoper\Symbol\SymbolsRegistry;
use ACSB\Vendor\PhpParser\PhpVersion;
interface ScoperFactory
{
    public function createScoper(Configuration $configuration, SymbolsRegistry $symbolsRegistry, ?PhpVersion $phpVersion = null): Scoper;
}
