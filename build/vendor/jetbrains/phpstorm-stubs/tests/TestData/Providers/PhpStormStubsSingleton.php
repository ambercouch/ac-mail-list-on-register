<?php

declare (strict_types=1);
namespace ACSB\Vendor\StubTests\TestData\Providers;

use ACSB\Vendor\StubTests\Model\StubsContainer;
use ACSB\Vendor\StubTests\Parsers\StubParser;
class PhpStormStubsSingleton
{
    private static ?StubsContainer $phpstormStubs = null;
    public static function getPhpStormStubs(): StubsContainer
    {
        if (self::$phpstormStubs === null) {
            self::$phpstormStubs = StubParser::getPhpStormStubs();
        }
        return self::$phpstormStubs;
    }
}
