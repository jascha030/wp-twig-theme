<?php

namespace Jascha030\TwigTheme\Twig;

use Jascha030\TwigTheme\Service\TwigServiceInterface;
use Twig\Environment;

class Post
{
    public static function render($post = null): void
    {
        $post = self::resolvePost($post ?? \get_the_ID());

        if (null === $post) {
            \twig_render('404.twig');

            return;
        }

        $theme = theme();

        $theme->get(Environment::class)
              ->addGlobal('post', (array) $post);

        $theme->get(TwigServiceInterface::class)
              ->render(static::getTemplate($post), []);
    }

    private static function resolvePost($post): ?\WP_Post
    {
        if (! self::isResolvable($post)) {
            return null;
        }

        if ($post instanceof \WP_Post) {
            return new \WP_Post($post);
        }

        $post = \WP_Post::get_instance($post);

        return $post !== false ? $post : null;
    }

    private static function isResolvable($post): bool
    {
        return is_string($post) || is_int($post) || $post instanceof \WP_Post;
    }

    private static function getTemplate(\WP_Post $post): string
    {
        $type = (get_post_type_object($post->post_type))->rewrite['slug']
                ?? $type->name
                   ?? $post->post_type;

        $template = "{$type}.twig";

        return file_exists(dirname(__FILE__, 3) . $template)
            ? $template
            : 'single.twig';
    }
}
