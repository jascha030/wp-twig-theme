<?php

/**
 * Theme's bootstrap script.
 *
 * Loads the composer autoloader based on its possible locations, within a WordPress install and adds function to init
 * theme's Container object.
 *
 * @see  ContainerInterface
 * @link https://www.php-fig.org/psr/psr-11/
 */

declare(strict_types=1);

use DI\ContainerBuilder;

/**
 * Returns private static resolver function to resolve the vendor/autoload.php location, which could be either in the
 * theme directory, the WordPress root, or a starter-environment git root.
 */
$loader = include __DIR__ . 'loader.php';

/**
 * Pass the theme root path to the resolver function.
 */
require_once $loader(dirname(__DIR__));

/**
 * Creates the main container
 * {@see init}
 *
 * @param string $configDir
 * @param array  $definitions
 *
 * @return \Psr\Container\ContainerInterface
 */
function init(string $configDir, array $definitions): Psr\Container\ContainerInterface
{
    $definition_paths = array_map(
        static function (string $fileName) use ($configDir) {
            return $configDir . $fileName;
        },
        $definitions
    );

    $builder = new ContainerBuilder();
    $builder->useAutowiring(false);
    $builder->useAnnotations(false);
    $builder->addDefinitions($definition_paths);

    try {
        $container = $builder->build();
    } catch (Exception $e) {
        if (!function_exists('wp_die')) {
            exit($e->getMessage());
        }

        wp_die($e->getMessage());
    }

    return $container;
}
