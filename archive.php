<?php

/**
 * The template for displaying archive pages.
 *
 * @see https://codex.wordpress.org/Template_Hierarchy
 */
get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part('templates/content/content', 'archive');
    }
} else {
    get_template_part('templates/content/content', 'none');
}

get_footer();
