<?php

use Jascha030\TwigTheme\Service\TwigServiceInterface;

require_once __DIR__ . '/includes/bootstrap.php';

function theme(): \Psr\Container\ContainerInterface
{
    static $theme;

    if (!isset($theme)) {
        $theme = init(
            __DIR__ . '/config/',
            [
                'theme.php',
                'twig.php',
            ]
        );
    }

    return $theme;
}

function twig_render(string $template, array $context = []): void
{
    theme()
        ->get(TwigServiceInterface::class)
        ->render($template, $context);
}
