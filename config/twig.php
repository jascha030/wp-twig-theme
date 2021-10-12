<?php

use Jascha030\TwigTheme\Service\TwigService;
use Jascha030\TwigTheme\Service\TwigServiceInterface;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

/**
 * Twig container definitions for php-di/php-di
 *
 * @link https://php-di.org/doc/php-definitions.html
 * @link https://twig.symfony.com/doc/3.x/
 */
return [
    /**
     * Env variables
     */
    'twig.root' => dirname(__DIR__) . '/templates',
    /**
     * Interfaces and class-bindings
     */
    LoaderInterface::class => static function (ContainerInterface $container): LoaderInterface {
        return new FilesystemLoader($container->get('twig.root'));
    },
    Environment::class => static function (ContainerInterface $container): Environment {
        return new Environment($container->get(LoaderInterface::class), []);
    },
    TwigServiceInterface::class => static function (ContainerInterface $container): TwigServiceInterface {
        return new TwigService($container->get(Environment::class));
    }
];
