<?php
declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

return [
    // All third-party deps (your vendor/) will be moved under this prefix
    'prefix' => 'ACSB\\Vendor',

    // Scope ONLY vendor/ (leave your plugin code alone)
    'finders' => [
        Finder::create()
              ->files()
              ->ignoreVCS(true)
              ->in(__DIR__ . '/vendor')
              ->exclude('humbug') // don't scope php-scoper itself if present
              ->exclude('bin'),

        // Include Composer runtime bits so the build is self-contained
        Finder::create()
              ->files()
              ->name('installed.php')
              ->name('autoload.php')
              ->name('ClassLoader.php')
              ->in(__DIR__ . '/vendor/composer'),
    ],

    // We don't need to share any public API; keep everything isolated:
    'expose-global-constants' => false,
    'expose-global-classes'   => false,
    'expose-global-functions' => false,
    'expose-namespaces'       => [],
    'expose-classes'          => [],
    'expose-functions'        => [],
    'expose-constants'        => [],

    // No patchers needed for Sendinblue/Guzzle in typical WP use
    'patchers' => [],
];
