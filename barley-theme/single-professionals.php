<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package barley-theme
 */

get_header();
    $header = get_field('fields_header', 'option');
    $main = get_field('prof_main_info');
    $photo = get_featured_img_info('medium_large', get_the_ID()); ?>
    <main class="main">
        <section class="bio-details">
            <?php if (isset($header['print_logo']['sizes'])) : ?>
                <div class="print-logo">
                    <img src="<?php echo $header['print_logo']['sizes']['medium']; ?>" alt="<?php echo $header['print_logo']['alt']; ?>">
                </div>
            <?php endif; ?>
            <div class="container">
                <div class="mobile-heading heading">
                    <p>
                        <a href="<?php echo get_post_type_archive_link('professionals'); ?>" class="back-link">
                            <?php get_template_part('template-parts/svg/back-to'); ?>
                            <span><?php echo __('Back to All Professionals', 'barley-theme'); ?></span>
                        </a>
                    </p>
                    <div class="h2"><?php the_title(); ?></div>
                    <?php if (isset($main['position']) && !empty($main['position'])) : ?>
                        <div class="position"><?php echo $main['position']; ?></div>
                    <?php endif; ?>
                    <?php echo $main['description']; ?>
                </div>
                <div class="bio-details-holder">
                    <div class="column">
                        <div class="bio-details-heading heading">
                            <a href="<?php echo get_post_type_archive_link('professionals')?>" class="back-link">
                                <?php get_template_part('template-parts/svg/back-to'); ?>
                                <span><?php echo __('Back to All Professionals', 'barley-theme'); ?></span>
                            </a>
                            <div class="h2"><?php the_title(); ?></div>
                            <?php if (isset($main['position']) && !empty($main['position'])) : ?>
                                <div class="position"><?php echo $main['position']; ?></div>
                            <?php endif; ?>
                            <?php echo $main['description']; ?>
                        </div>
                        <?php get_template_part('template-parts/single/contact-info'); ?>
                        <div class="content">
                            <?php while (have_posts()):
                                the_post();
                                the_content();
                            endwhile; ?>
                        </div>
                    </div>
                    <div class="column">
                        <?php if (isset($photo['src'])) : ?>
                            <div class="photo-holder">
                                <img src="<?php echo $photo['src']; ?>" alt="<?php echo $photo['alt']; ?>">
                            </div>
                        <?php endif; ?>
                        <?php get_template_part('template-parts/single/education-info'); ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
        get_template_part('template-parts/single/representative-transactions');
        get_template_part('template-parts/single/latest-news');
        get_template_part('template-parts/single/related-resources');
        get_template_part('template-parts/single/upcoming-events');
        ?>
    </main>
<?php get_footer();