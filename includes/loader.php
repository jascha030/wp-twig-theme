<?php

declare(strict_types=1);

/**
 * Returns the right path to autoload.php based on vendor location.
 *
 * @uses ABSPATH
 * @link https://developer.wordpress.org/reference/classes/wp_filesystem_base/abspath/
 * @link https://getcomposer.org/doc/01-basic-usage.md
 * @link https://wpackagist.org/
 */
return static function (string $themeRootPath): string {
    $prioritisedAutoloaders = [
        $themeRootPath . '/vendor/autoload.php',
        ABSPATH . '/vendor/autoload.php',
        dirname(ABSPATH) . '/vendor/autoload.php',
        dirname(ABSPATH, 2) . '/vendor/autoload.php',
    ];

    foreach ($prioritisedAutoloaders as $autoloaderPath) {
        if (is_file($autoloaderPath)) {
            return $autoloaderPath;
        }
    }

    $errorMsg = sprintf('Couldn\'t find Composer\'s Autoloader file in any of the following paths:
                %s, please make sure you run the %s or %s commands.',
        implode(', ', $prioritisedAutoloaders),
        '<pre>composer install --prefer-source</pre>',
        '<pre>composer dump-autoload</pre>');

    throw new \RuntimeException($errorMsg);
};
