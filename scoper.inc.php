<?php
declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

return [
    'prefix' => 'ACSB\\Vendor',

    // Scope ONLY your composer deps
    'finders' => [
        Finder::create()
              ->files()
              ->ignoreVCS(true)
              ->in(__DIR__ . '/vendor')
              ->exclude('humbug') // don’t scope scoper itself
              ->exclude('bin'),
    ],

    'expose-global-constants' => false,
    'expose-global-classes'   => false,
    'expose-global-functions' => false,
    'expose-namespaces'       => [],
    'expose-classes'          => [],
    'expose-functions'        => [],
    'expose-constants'        => [],
    'patchers' => [],
];
