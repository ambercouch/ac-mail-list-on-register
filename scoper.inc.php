<?php
declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

return [
    // Private namespace for ALL third-party code (including Composer runtime)
    'prefix' => 'ACSB\\Vendor',

    // Scope EVERYTHING in vendor/ (incl. vendor/composer)
    'finders' => [
        Finder::create()
              ->files()
              ->ignoreVCS(true)
              ->in(__DIR__ . '/vendor'),
    ],

    // Keep everything isolated
    'expose-global-constants' => false,
    'expose-global-classes'   => false,
    'expose-global-functions' => false,
    'expose-namespaces'       => [],
    'expose-classes'          => [],
    'expose-functions'        => [],
    'expose-constants'        => [],

    // Patch Composer's bootstrap string literals after prefixing
    'patchers' => [
        static function (string $filePath, string $prefix, string $contents): string {
            if (basename($filePath) !== 'autoload_real.php') {
                return $contents;
            }

            // 1) Make the bootstrap autoloader load the *prefixed* ClassLoader
            //    'Composer\Autoload\ClassLoader'  --> 'ACSB\Vendor\Composer\Autoload\ClassLoader'
            $contents = str_replace(
                "'Composer\\\\Autoload\\\\ClassLoader'",
                "'" . $prefix . "\\\\Composer\\\\Autoload\\\\ClassLoader'",
                $contents
            );

            // 2) Fix the unregister call to reference the *prefixed* ComposerAutoloaderInit...
            //    spl_autoload_unregister(['ComposerAutoloaderInit...','loadClassLoader'])
            //    --> prefixed version
            $contents = preg_replace(
                '/spl_autoload_unregister\(\s*array\(\s*[\'"]ComposerAutoloaderInit/',
                'spl_autoload_unregister(array(\'' . $prefix . '\\\\ComposerAutoloaderInit',
                $contents
            ) ?? $contents;

            return $contents;
        },
    ],
];
