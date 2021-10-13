<?php

use Jascha030\TwigTheme\Service\TwigService;
use Jascha030\TwigTheme\Service\TwigServiceInterface;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Twig container definitions for php-di/php-di
 *
 * @see  ContainerInterface
 * @see  \DI\Container
 * @link https://php-di.org/doc/php-definitions.html
 * @link https://twig.symfony.com/doc/3.x/
 */
return [
    /**
     * Twig env variables
     *
     * @see \Twig\Environment
     */
    'twig.root'                 => dirname(__DIR__) . '/templates',
    /**
     * Twig Extensions
     *
     * @link https://twig.symfony.com/doc/3.x/advanced.html
     *
     * twig.functions
     *
     * @see TwigFunction
     * @link https://twig.symfony.com/doc/3.x/advanced.html#functions
     *
     * twig.filters
     *
     * @see TwigFilter
     * @link https://twig.symfony.com/doc/3.x/advanced.html#filters
     */
    'twig.functions'            => static function (ContainerInterface $container) {
        return [
            // Adds WordPress' do_action and do_filter functions as twig functions to be used inside templates.
            'action' => static function (string $tag, ...$arguments): void {
                do_action($tag, ...$arguments);
            },
            'filter' => static function (string $tag, ...$arguments): void {
                do_filter($tag, ...$arguments);
            },
            'parse_blocks' => static function (string $content): array {
                return parse_blocks($content);
            },
            'render_block' => static function (array $content): string {
                return render_block($content);
            }
        ];
    },
    'twig.filters'              => static function (ContainerInterface $container) {
        return [
            'translatable' => static function (string $string) use ($container) {
                return __($string, $container->get('theme.domain'));
            }
        ];
    },
    /**
     * Interfaces and class-bindings
     *
     * @see  LoaderInterface
     * @uses \Twig\Loader\FilesystemLoader
     */
    LoaderInterface::class      => static function (ContainerInterface $container): LoaderInterface {
        return new FilesystemLoader($container->get('twig.root'));
    },
    /**
     * Twig Environment factory binding.
     *
     * @see   LoaderInterface
     * @uses  LoaderInterface::class, as key to retrieve the defined loader from the container.
     * @uses  'twig.functions' key to retrieve twig function extensions to be added to Environment, from the container.
     * @uses  'twig.filters'   key to retrieve twig filter extensions to be added to Environment, from the container.
     */
    Environment::class          => static function (ContainerInterface $container): Environment {
        $environment = new Environment($container->get(LoaderInterface::class));

        foreach ($container->get('twig.functions') as $key => $closure) {
            $environment->addFunction(new TwigFunction($key, $closure));
        }

        foreach ($container->get('twig.filters') as $key => $closure) {
            $environment->addFilter(new TwigFilter($key, $closure));
        }

        $environment->addGlobal('post', []);

        return $environment;
    },
    TwigServiceInterface::class => static function (ContainerInterface $container): TwigServiceInterface {
        return new TwigService($container->get(Environment::class));
    },
];
