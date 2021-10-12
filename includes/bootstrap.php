<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$loader = include __DIR__ . 'loader.php';

require_once $loader(dirname(__DIR__));

$definition_files = [
    dirname(__DIR__) . '/config/theme.php'
];

function init(array $definitions): Psr\Container\ContainerInterface
{
    $builder = new ContainerBuilder();
    $builder->useAutowiring(false);
    $builder->useAnnotations(false);
    $builder->addDefinitions($definitions);

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
