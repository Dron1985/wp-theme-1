<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package barley-theme
 */

get_header(); ?>
    <main class="main">
        <div class="container">
            <article class="article content">
                <?php while (have_posts()) : the_post();
                    the_content();
                endwhile; ?>
            </article>
        </div>
    </main>
<?php get_footer();