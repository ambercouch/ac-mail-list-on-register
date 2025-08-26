<?php

declare (strict_types=1);
namespace ACSB\Vendor\StubTests\Parsers;

use ACSB\Vendor\PhpParser\Error;
use ACSB\Vendor\PhpParser\ErrorHandler;
class StubsParserErrorHandler implements ErrorHandler
{
    public function handleError(Error $error): void
    {
        $error->setRawMessage($error->getRawMessage() . "\n" . $error->getFile());
    }
}
