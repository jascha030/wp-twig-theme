<?php

namespace Jascha030\TwigTheme\Service;

use Twig\Environment;

interface TwigServiceInterface
{
    /**
     * Pass the twig environment to the constructor
     */
    public function __construct(Environment $environment);

    /**
     * Get output string
     *
     * @param string $template
     * @param array  $context
     *
     * @return string
     */
    public function getString(string $template, array $context): string;

    /**
     * Render the output string
     *
     * @param string $template
     * @param array  $context
     */
    public function render(string $template, array $context): void;
}
