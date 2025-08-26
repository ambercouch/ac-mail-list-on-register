<?php

namespace ACSB\Vendor;

use ACSB\Vendor\JetBrains\PhpStorm\Pure;
/**
 * @since 8.1
 */
class ReflectionIntersectionType extends \ReflectionType
{
    /** @return ReflectionType[] */
    #[Pure]
    public function getTypes(): array
    {
    }
}
/**
 * @since 8.1
 */
\class_alias('ACSB\Vendor\ReflectionIntersectionType', 'ReflectionIntersectionType', \false);
