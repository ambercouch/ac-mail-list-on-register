<?php

namespace ACSB\Vendor;

use ACSB\Vendor\JetBrains\PhpStorm\Pure;
/**
 * @link https://php.net/manual/en/class.reflectionenumbackedcase.php
 * @since 8.1
 */
class ReflectionEnumBackedCase extends \ReflectionEnumUnitCase
{
    public function __construct(object|string $class, string $constant)
    {
    }
    #[Pure]
    public function getBackingValue(): int|string
    {
    }
}
/**
 * @link https://php.net/manual/en/class.reflectionenumbackedcase.php
 * @since 8.1
 */
\class_alias('ACSB\Vendor\ReflectionEnumBackedCase', 'ReflectionEnumBackedCase', \false);
