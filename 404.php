<?php
/**
 * The main 404 (not found) page.
 *
 * @see https://codex.wordpress.org/Template_Hierarchy
 */
get_header();

twig_render('404.twig');

get_footer();
