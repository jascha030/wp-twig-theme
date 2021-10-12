<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$loader = include __DIR__ . 'loader.php';

require_once $loader(dirname(__DIR__));

/**
 * Creates the main container
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
        exit;
    }

    return $container;
}
