<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package barley-theme
 */
get_header();

    global $post;
    $url = add_query_arg( array(
        'download_pdf' => $post->post_name,
        'type' => $post->post_type,
        'printformat' => 'PrintPDF'
    ), home_url('download-brochure/'));

    $header     = get_field('fields_header', 'option');
    $short_desc = get_field('capability_short_desc');
    $chairs     = get_field('capability_chairs');
    $professionals = get_leadership_by_id(get_the_ID());
    $areas      = get_areas_list(get_the_ID()); ?>
    <main class="main">
        <?php if (isset($header['print_logo']['sizes'])) : ?>
            <div class="print-logo">
                <img src="<?php echo $header['print_logo']['sizes']['medium']; ?>" alt="<?php echo $header['print_logo']['alt']; ?>">
            </div>
        <?php endif; ?>
        <div class="container">
            <p>
                <a href="<?php echo get_post_type_archive_link('capability'); ?>" class="back-link">
                    <?php get_template_part('template-parts/svg/back-to'); ?>
                    <span><?php echo __('Back to All Capabilities', 'barley-theme'); ?></span>
                </a>
            </p>
            <div class="column-heading">
                <div class="wrap">
                    <h1 class="h2"><?php the_title(); ?></h1>
                    <?php echo $short_desc; ?>
                </div>
                <div class="print-ico-pdf">
                    <a href="<?php echo $url; ?>" class="back-link" target="_blank" rel="nofollow">
                        <?php get_template_part('template-parts/svg/arrow-left'); ?>
                        <span><?php echo __('Download PDF', 'barley-theme'); ?></span>
                    </a>
                </div>
            </div>
        </div>
        <!--column-heading-->
        <div class="add-page-menu">
            <div class="container">
                <nav>
                    <ul>
                        <li><a class="anchor-link" href="#overview"><?php echo __('Overview', 'barley-theme'); ?></a></li>
                        <?php if (!empty($professionals)) : ?>
                            <li><a class="anchor-link" href="#professionals"><?php echo __('Professionals', 'barley-theme'); ?></a></li>
                        <?php endif; ?>
                        <?php if (have_rows('capability_content')) :
                            while (have_rows('capability_content')) : the_row();
                                if (get_row_layout() == 'testimonial_block') :
                                    echo (get_sub_field('title')) ? '<li><a class="anchor-link" href="#testimonials">'.get_sub_field('title').'</a></li>' : '';
                                elseif (get_row_layout() == 'insights_block') :
                                    echo (get_sub_field('title')) ? '<li><a class="anchor-link" href="#insights">'.get_sub_field('title').'</a></li>' : '';
                                elseif (get_row_layout() == 'info_block') :
                                    echo (get_sub_field('title')) ? '<li><a class="anchor-link" href="#representative">'.get_sub_field('title').'</a></li>' : '';
                                endif;
                            endwhile;
                        endif;?>
                    </ul>
                </nav>
            </div>
        </div>
        <!--add-page-menu-->
        <div class="container">
            <div class="page-holder">
                <div>
                    <div id="overview" class="overview-block content">
                        <?php while (have_posts()):
                            the_post();
                            the_content();
                        endwhile; ?>
                    </div>
                    <!--overview-block-->

                    <?php if (!empty($chairs)) :
                        $title = (count($chairs) > 1) ? 'Chairs' : 'Chair'; ?>
                        <div class="aside-info-wrap print">
                            <h4><?php echo $title; ?></h4>
                            <div class="team-list">
                                <?php foreach ($chairs as $chair) :
                                    $show_popup = get_field('disclaimer_popup', $chair->ID);
                                    $field = get_field('contact_info', $chair->ID);
                                    $photo = get_featured_img_info('medium_large', $chair->ID); ?>
                                    <div class="item">
                                        <?php if (isset($photo['src'])) : ?>
                                            <div class="photo-holder">
                                                <div class="photo" style="background-image: url('<?php echo $photo['src']; ?>')">
                                                    <a href="<?php echo get_the_permalink($chair->ID); ?>"></a>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <h6><a href="<?php echo get_the_permalink($chair->ID); ?>"><?php echo get_the_title($chair->ID); ?></a></h6>
                                        <?php if (isset($field['position']) && !empty($field['position'])) : ?>
                                            <div class="person-post"><?php echo $field['position']; ?></div>
                                        <?php endif; ?>

                                        <?php if (isset($field['phone']) && !empty($field['phone'])) : ?>
                                            <p><a href="<?php echo phone_url($field['phone']); ?>"><?php echo $field['phone']; ?></a></p>
                                        <?php endif; ?>

                                        <?php if (isset($field['email']) && !empty($field['email'])) :
                                            if ($show_popup == true) : ?>
                                                <p><a href="#bio-popup" class="popup-opener"><?php echo $field['email']; ?></a></p>
                                            <?php else: ?>
                                                <p><a href="mailto:<?php echo $field['email']; ?>"><?php echo $field['email']; ?></a></p>
                                            <?php endif;
                                        endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($professionals)) : ?>
                        <div id="professionals" class="leadership">
                            <h3><?php echo __('Professionals', 'barley-theme'); ?></h3>
                            <div class="team-list three-in-row">
                                <?php foreach ($professionals as $professional) :
                                    set_query_var('post_id', $professional['id']);
                                    get_template_part('template-parts/archive/item-professional');
                                endforeach; ?>
                            </div>
                        </div>
                        <!--professionals-->
                    <?php endif; ?>
                </div>
                <aside>
                    <?php if (!empty($areas)) : ?>
                        <div class="aside-info-wrap content">
                            <?php if (isset($areas['main']) && !empty($areas['main'])) : ?>
                                <h6><?php echo __('Main Area', 'barley-theme'); ?></h6>
                                <p><a href="<?php echo get_the_permalink($areas['main']['id']); ?>"><?php echo $areas['main']['title']; ?></a></p>
                            <?php endif; ?>
                            <?php if (isset($areas['focus_areas']) && !empty($areas['focus_areas'])) : ?>
                                <h6><?php echo __('Focus Areas', 'barley-theme'); ?></h6>
                                <?php foreach ($areas['focus_areas'] as $item) : ?>
                                    <p><a href="<?php echo get_the_permalink($item['id']); ?>"><?php echo $item['title']; ?></a></p>
                                <?php endforeach;
                            endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($chairs)) :
                        $title = (count($chairs) > 1) ? 'Chairs' : 'Chair'; ?>
                        <div class="aside-info-wrap">
                            <h4><?php echo $title; ?></h4>
                            <div class="team-list">
                                <?php foreach ($chairs as $chair) :
                                    $field = get_field('contact_info', $chair->ID);
                                    $photo = get_featured_img_info('medium_large', $chair->ID); ?>
                                    <div class="item">
                                        <?php if (isset($photo['src'])) : ?>
                                            <div class="photo-holder">
                                                <div class="photo" style="background-image: url('<?php echo $photo['src']; ?>')">
                                                    <a href="<?php echo get_the_permalink($chair->ID); ?>"></a>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <h6><a href="<?php echo get_the_permalink($chair->ID); ?>"><?php echo get_the_title($chair->ID); ?></a></h6>
                                        <?php if (isset($field['position']) && !empty($field['position'])) : ?>
                                            <div class="person-post"><?php echo $field['position']; ?></div>
                                        <?php endif; ?>

                                        <?php if (isset($field['phone']) && !empty($field['phone'])) : ?>
                                            <p><a href="<?php echo phone_url($field['phone']); ?>"><?php echo $field['phone']; ?></a></p>
                                        <?php endif; ?>

                                        <?php if (isset($field['email']) && !empty($field['email'])) : ?>
                                            <p><a href="mailto:<?php echo $field['email']; ?>"><?php echo $field['email']; ?></a></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
        <!--page holder-->
        <?php if (have_rows('capability_content')) :
            while (have_rows('capability_content')) : the_row();

                if (get_row_layout() == 'testimonial_block') :
                    get_template_part('template-parts/single/testimonial','block');

                elseif (get_row_layout() == 'insights_block') :
                    $show_news = get_sub_field('show_news');
                    $show_resources = get_sub_field('show_resources');
                    $show_events = get_sub_field('show_events');
                    echo '<div id="insights">';
                    get_template_part('template-parts/single/latest-news', null, ['show_news' => $show_news] );
                    get_template_part('template-parts/single/related-resources', null, ['show_resources' => $show_resources]);
                    get_template_part('template-parts/single/upcoming-events', null, ['show_events' => $show_events]);
                    echo '</div>';

                elseif (get_row_layout() == 'info_block') :
                    get_template_part('template-parts/single/representative-transactions');
                endif;

            endwhile;
        endif;?>
    </main>
<?php get_footer(); ?>