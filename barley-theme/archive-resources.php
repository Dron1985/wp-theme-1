<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package barley-theme
 */

get_header(); ?>
    <main class="main">
        <?php get_template_part('template-parts/global/hero-section'); ?>
        <?php get_template_part('template-parts/archive/resources-listing'); ?>
    </main>
<?php get_footer();