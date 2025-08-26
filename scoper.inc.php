<?php
declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

return [
    // All *third-party* code will live under this private prefix:
    'prefix' => 'ACSB\\Vendor',

    // Scope only the dependencies (vendor/) — not your plugin code
    'finders' => [
        // Everything under vendor/
        Finder::create()
              ->files()
              ->ignoreVCS(true)
              ->in(__DIR__ . '/vendor')
              ->exclude('humbug') // don't scope scoper itself
              ->exclude('bin'),
    ],

    // Keep everything isolated; we don't expose shared symbols
    'expose-global-constants' => false,
    'expose-global-classes'   => false,
    'expose-global-functions' => false,
    'expose-namespaces'       => [],
    'expose-classes'          => [],
    'expose-functions'        => [],
    'expose-constants'        => [],

    'patchers' => [],
];
