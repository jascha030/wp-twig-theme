<?php
/**
 * The template for displaying all single posts.
 *
 * @see https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */
get_header();

while (have_posts()) {
    the_post();
    get_template_part('templates/content/content', get_post_type_object(get_post_type())->rewrite['slug']);
}

get_footer();
