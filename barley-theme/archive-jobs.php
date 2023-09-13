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
        <?php get_template_part('template-parts/archive/careers-listing'); ?>
        <?php get_template_part('template-parts/blocks/careers/banner'); ?>
        <?php get_template_part('template-parts/blocks/careers/benefits'); ?>
        <?php get_template_part('template-parts/blocks/careers/contact-block'); ?>
    </main>
<?php get_footer();