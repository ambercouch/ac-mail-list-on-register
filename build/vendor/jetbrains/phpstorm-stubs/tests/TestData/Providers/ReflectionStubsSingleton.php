<?php

namespace ACSB\Vendor\StubTests\TestData\Providers;

use ACSB\Vendor\StubTests\Model\StubsContainer;
use ACSB\Vendor\StubTests\Parsers\PHPReflectionParser;
class ReflectionStubsSingleton
{
    /**
     * @var StubsContainer|null
     */
    private static $reflectionStubs;
    /**
     * @return StubsContainer
     */
    public static function getReflectionStubs()
    {
        if (self::$reflectionStubs === null) {
            self::$reflectionStubs = PHPReflectionParser::getStubs();
        }
        return self::$reflectionStubs;
    }
}
