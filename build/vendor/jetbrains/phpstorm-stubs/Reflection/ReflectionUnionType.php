<?php

namespace ACSB\Vendor;

use ACSB\Vendor\JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use ACSB\Vendor\JetBrains\PhpStorm\Pure;
/**
 * @since 8.0
 */
class ReflectionUnionType extends \ReflectionType
{
    /**
     * Get list of types of union type
     *
     * @return ReflectionNamedType[]|ReflectionIntersectionType[]
     */
    #[Pure]
    #[LanguageLevelTypeAware(['8.2' => 'ReflectionNamedType[]|ReflectionIntersectionType[]'], default: 'ReflectionNamedType[]')]
    public function getTypes(): array
    {
    }
}
/**
 * @since 8.0
 */
\class_alias('ACSB\Vendor\ReflectionUnionType', 'ReflectionUnionType', \false);
