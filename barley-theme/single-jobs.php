<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package barley-theme
 */

get_header();
$main = get_field('job_main_info');
$apply_form = get_field('job_apply_form'); ?>
    <main class="main">
        <div class="job-details">
            <div class="container">
                <div class="heading">
                    <p>
                        <a href="<?php echo get_post_type_archive_link('jobs')?>" class="back-link">
                            <?php get_template_part('template-parts/svg/back-to'); ?>
                            <span><?php echo __('Back to Career Opportunities', 'barley-theme'); ?></span>
                        </a>
                    </p>
                    <h1 class="h2"><?php the_title(); ?></h1>
                    <?php echo $main['description']; ?>
                    <a href="#apply-now" class="button anchor-link">
                        <?php echo __('Apply Now', 'barley-theme'); ?>
                        <?php echo get_template_part('template-parts/svg/arrow-right'); ?>
                    </a>
                </div>
                <div class="job-description content">
                    <?php if (isset($main['location']) && !empty($main['location'])) : ?>
                        <div class="location">
                            <div class="ico"><img src="<?php echo get_template_directory_uri(); ?>/dist/images/ico-locations.svg" alt="ico"></div>
                            <strong class="city"><?php echo $main['location']->post_title; ?></strong>
                        </div>
                    <?php endif; ?>
                    <?php while (have_posts()):
                        the_post();
                        the_content();
                    endwhile; ?>
                </div>
            </div>
        </div>
        <!--job-details-->
        <section id="apply-now" class="apply-now">
            <div class="container">
                <?php if (isset($apply_form['title']) && !empty($apply_form['title'])) : ?>
                    <h3><?php echo $apply_form['title']; ?></h3>
                <?php endif; ?>

                <?php if (isset($apply_form['subtitle']) && !empty($apply_form['subtitle'])) : ?>
                    <h4><?php echo $apply_form['subtitle']; ?></h4>
                <?php endif; ?>
                <?php if (class_exists('WPCF7')) {
                    echo do_shortcode('[contact-form-7 id="513" title="Apply form"]');
                } ?>
            </div>
        </section>
    </main>
<?php get_footer();