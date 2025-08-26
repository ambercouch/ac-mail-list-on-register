<?php

declare (strict_types=1);
namespace ACSB\Vendor\StubTests\Parsers;

use ACSB\Vendor\phpDocumentor\Reflection\DocBlockFactory;
use ACSB\Vendor\StubTests\Model\Tags\RemovedTag;
class DocFactoryProvider
{
    private static ?DocBlockFactory $docFactory = null;
    public static function getDocFactory(): DocBlockFactory
    {
        if (self::$docFactory === null) {
            self::$docFactory = DocBlockFactory::createInstance(['removed' => RemovedTag::class]);
        }
        return self::$docFactory;
    }
}
