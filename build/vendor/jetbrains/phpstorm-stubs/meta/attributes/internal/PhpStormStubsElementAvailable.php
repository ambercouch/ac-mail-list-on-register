<?php

namespace ACSB\Vendor\JetBrains\PhpStorm\Internal;

use Attribute;
use ACSB\Vendor\JetBrains\PhpStorm\Deprecated;
use ACSB\Vendor\JetBrains\PhpStorm\ExpectedValues;
/**
 * For PhpStorm internal use only
 * @since 8.0
 * @internal
 */
#[Attribute(Attribute::TARGET_FUNCTION | Attribute::TARGET_METHOD | Attribute::TARGET_PARAMETER)]
class PhpStormStubsElementAvailable
{
    public function __construct(
        #[ExpectedValues(Deprecated::PHP_VERSIONS)]
        $from,
        #[ExpectedValues(Deprecated::PHP_VERSIONS)]
        $to = null
    )
    {
    }
}
