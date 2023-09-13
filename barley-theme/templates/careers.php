<?php
/**
 *    Template Name: Careers
 **/

get_header(); ?>
    <main class="main">
        <?php get_template_part('template-parts/global/hero-section'); ?>
        <?php while (have_posts()):
            the_post();
            the_content();
        endwhile; ?>
    </main>
<?php get_footer(); ?>