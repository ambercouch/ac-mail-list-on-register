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
namespace ACSB\Vendor\Humbug\PhpScoper\PhpParser\Parser;

use ACSB\Vendor\PhpParser\Lexer;
use ACSB\Vendor\PhpParser\Lexer\Emulative;
use ACSB\Vendor\PhpParser\Parser;
use ACSB\Vendor\PhpParser\Parser\Php7;
use ACSB\Vendor\PhpParser\Parser\Php8;
use ACSB\Vendor\PhpParser\PhpVersion;
final class StandardParserFactory implements ParserFactory
{
    public function createParser(?PhpVersion $phpVersion = null): Parser
    {
        $version = $phpVersion ?? PhpVersion::getHostVersion();
        $lexer = $version->isHostVersion() ? new Lexer() : new Emulative($version);
        return $version->id >= 80000 ? new Php8($lexer, $version) : new Php7($lexer, $version);
    }
}
