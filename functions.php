<?php

use Jascha030\TwigTheme\Service\TwigServiceInterface;
use Psr\Container\ContainerInterface;

require_once __DIR__ . '/includes/bootstrap.php';

/**
 * Wrapper function to either initialize or retrieve the Theme's container instance.
 * {@see theme}
 *
 * @see init
 * @uses \Psr\Container\ContainerInterface
 * @uses \DI\Container
 */
function theme(): ContainerInterface
{
    static $theme;

    if (! isset($theme)) {
        $theme = init(__DIR__ . '/config/', [
            'theme.php',
            'twig.php',
        ]);
    }

    return $theme;
}

/**
 * Helper method to render twig template
 * {@see 'twig_render'}
 *
 * @param string $template template name relative to template root
 * @param array  $context
 *
 * @uses \Jascha030\TwigTheme\Service\TwigServiceInterface
 * @uses \Jascha030\TwigTheme\Service\TwigService
 * @uses \Psr\Container\ContainerInterface
 */
function twig_render(string $template, array $context = []): void
{
    theme()->get(TwigServiceInterface::class)->render($template, $context);
}
