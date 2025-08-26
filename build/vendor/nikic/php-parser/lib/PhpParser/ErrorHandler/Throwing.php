<?php

declare (strict_types=1);
namespace ACSB\Vendor\PhpParser\ErrorHandler;

use ACSB\Vendor\PhpParser\Error;
use ACSB\Vendor\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements ErrorHandler
{
    public function handleError(Error $error): void
    {
        throw $error;
    }
}
