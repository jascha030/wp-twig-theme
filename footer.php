<?php

/**
 * Theme footer: Renders footer element, calls wp_footer action and renders html closing tags.
 *
 * @see      wp_footer
 * @see      twig_render
 * @link     https://codex.wordpress.org/Template_Hierarchy
 * @template templates/footer.twig
 */
twig_render('footer.twig', ['closing_html' => '</body></html>']);
