<?php
/**
 *    Template Name: Contact US
 **/

get_header();
    $get_in_touch = get_field('get_in_touch'); ?>
    <main class="main">
        <?php get_template_part('template-parts/global/hero-section'); ?>
        <div class="container">
            <?php while (have_posts()):
                the_post();
                the_content();
            endwhile; ?>
        </div>
        <div class="get-in-touch">
            <div class="container">
                <div class="heading">
                    <?php if (isset($get_in_touch['title']) && !empty($get_in_touch['title'])) : ?>
                        <h3><?php echo $get_in_touch['title']; ?></h3>
                    <?php endif; ?>
                    <?php echo $get_in_touch['description']; ?>
                </div>
                <?php if (isset($get_in_touch['contact_form']) && !empty($get_in_touch['contact_form'])) {
                    echo do_shortcode($get_in_touch['contact_form']);
                } ?>
            </div>
        </div>
        <!--get-in-touch-->
    </main>
<?php get_footer(); ?>