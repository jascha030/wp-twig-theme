<?php

namespace Jascha030\TwigTheme\Twig;

class Loop
{
    private \WP_Query $query;

    private bool $global;

    private function __construct(\WP_Query $query, bool $global = false)
    {
        $this->query  = $query;
        $this->global = $global;

        $this->init();
    }

    public static function start(\WP_Query $query = null): self
    {
        if (! $query) {
            global $wp_query;

            return new self($wp_query, true);
        }

        return new self($query);
    }

    private function init(): void
    {
        if ($this->global) {
            $this->loopGlobal();

            return;
        }

        $this->loop();
    }

    private function loopGlobal(): void
    {
        if (! have_posts()) {
            \twig_render('content/none.twig');

            return;
        }

        while (have_posts()) {
            the_post();

            Post::render();
        }
    }

    private function loop(): void
    {
        if (! $this->query->have_posts()) {
            \twig_render('content/none.twig');

            return;
        }

        while ($this->query->have_posts()) {
            $this->query->the_post();

            Post::render($this->query->post);
        }
    }
}
