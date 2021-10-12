<?php

namespace Jascha030\TwigTheme\Service;

use Twig\Environment;

class TwigService implements TwigServiceInterface
{
    private Environment $environment;

    /**
     * {@inheritdoc}
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getString(string $template, array $context): string
    {
        return $this->environment->render($template, $context);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(string $template, array $context): void
    {
        ob_start();
        echo $this->getString($template, $context);

        echo ob_get_clean();
    }
}
