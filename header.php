<?php

/**
 * Theme header: Renders HTML document tag, head element and body opening tag.
 *
 * @see      wp_head
 * @see      twig_render
 * @link     https://codex.wordpress.org/Template_Hierarchy
 * @template templates/header.twig
 */
twig_render('header.twig', [
    'language_attributes' => get_language_attributes(),
    'charset'             => get_bloginfo('charset'),
    'title'               => wp_title(),
    'body_classes'        => get_body_class(),
]);
