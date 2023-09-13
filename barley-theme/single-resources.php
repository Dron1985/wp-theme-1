<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package barley-theme
 */

get_header();
$main = get_field('resource_main_info');
$sidebar = get_field('resource_sidebar');
$image = get_featured_img_info('medium_large', get_the_ID());
$categories = get_categories_list(get_the_ID(), 'list');
$type_author = get_field('type_author'); ?>
    <main class="main">
        <div class="container">
            <div class="info-details">
                <div class="description">
                    <p>
                        <a href="<?php echo get_post_type_archive_link('resources'); ?>" class="back-link">
                            <?php get_template_part('template-parts/svg/back-to'); ?>
                            <span><?php echo __('Back to Resources', 'barley-theme'); ?></span>
                        </a>
                    </p>
                    <?php if (!empty($categories)) : ?>
                        <ul class="article-tags">
                            <?php echo $categories; ?>
                        </ul>
                    <?php endif; ?>
                    <h3><?php the_title(); ?></h3>
                    <?php echo $main['short_desc']; ?>
                    <div class="get-report">
                        <?php if (isset($main['pdf_file']['url'])) :
                            $pdf_size = formatSizeUnits($main['pdf_file']['filesize']); ?>
                            <div>
                                <a href="<?php echo $main['pdf_file']['url']; ?>" class="button" target="_blank">
                                    <?php echo __('Get the Report', 'barley-theme'); ?>
                                    <?php get_template_part('template-parts/svg/pdf'); ?>
                                </a>
                                <span class="file-size"><?php echo $pdf_size; ?></span>
                            </div>
                        <?php endif; ?>
                        <?php get_template_part('template-parts/single/share'); ?>
                    </div>
                </div>
                <?php if (!empty($image['src'])) : ?>
                    <div class="image">
                        <img src="<?php echo $image['src']; ?>" alt="<?php echo $image['alt']; ?>">
                    </div>
                <?php endif; ?>
            </div>
            <!--info-details-->
            <div class="page-holder article-holder">
                <div class="article-content content">
                    <?php while (have_posts()):
                        the_post();
                        the_content();
                    endwhile; ?>
                </div>
                <!--article-content-->
                <aside class="article-aside">
                    <?php if ($type_author != 'hide') :
                        $authors = ($type_author == 'professionals') ? get_field('professionals_list') : get_field('authors'); ?>
                        <div class="speakers">
                            <?php if (get_field('title_written_by')) : ?>
                                <h4><?php echo get_field('title_written_by'); ?></h4>
                            <?php endif; ?>
                            <div class="team-list columns">
                                <?php foreach ($authors as $author) :
                                    if ($type_author == 'professionals') {
                                        $show_popup = get_field('disclaimer_popup', $author->ID);
                                        $field    = get_field('contact_info', $author->ID);
                                        $name     = (isset($author->post_title)) ? $author->post_title : '';
                                        $phone    = (isset($field['phone']) && !empty($field['phone'])) ? $field['phone'] : '';
                                        $email    = (isset($field['email']) && !empty($field['email'])) ? $field['email'] : '';
                                        $photo    = get_featured_img_info('thumbnail', $author->ID)['src'];
                                        $link     = get_the_permalink($author->ID);
                                        $linkedin = (isset($field['connect_field']['link_linkedin']) && !empty($field['connect_field']['link_linkedin'])) ? $field['connect_field']['link_linkedin'] : '';
                                    } else {
                                        $show_popup = false;
                                        $name     = (isset($author['full_name']) && !empty($author['full_name'])) ? $author['full_name'] : '';
                                        $phone    = (isset($author['phone']) && !empty($author['phone'])) ? $author['phone'] : '';
                                        $email    = (isset($author['email']) && !empty($author['email'])) ? $author['email'] : '';
                                        $photo    = (isset($author['photo']['sizes'])) ? $author['photo']['sizes']['thumbnail'] : '';
                                        $linkedin = (isset($author['linkedin']) && !empty($author['linkedin'])) ? $author['linkedin'] : '';
                                    } ?>
                                    <div class="item">
                                        <?php if (!empty($photo)) : ?>
                                            <div class="photo-holder">
                                                <div class="photo" style="background-image: url('<?php echo $photo; ?>')">
                                                    <?php echo (isset($link)) ? '<a href="'.$link.'"></a>' : ''; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="person-contacts">
                                            <?php ?>
                                            <?php if ($type_author == 'professionals') : ?>
                                                <h6><a href="<?php echo $link; ?>"><?php echo $name; ?></a></h6>
                                            <?php else : ?>
                                                <h6><?php echo $name; ?></h6>
                                            <?php endif; ?>

                                            <?php if (!empty($phone) || !empty($email)) : ?>
                                                <ul>
                                                    <li><a href="<?php echo phone_url($phone); ?>"><?php echo $phone; ?></a></li>
                                                    <?php if ($show_popup == true && !empty($email)) : ?>
                                                        <li><a href="#bio-popup" class="popup-opener"><?php echo $email; ?></a></li>
                                                    <?php elseif ($show_popup == false && !empty($email)): ?>
                                                        <li><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>
                                                    <?php endif; ?>
                                                </ul>
                                            <?php endif; ?>

                                            <?php if (!empty($linkedin)) : ?>
                                                <ul class="social-list">
                                                    <li>
                                                        <a href="<?php echo $linkedin; ?>" target="_blank" rel="nofollow">
                                                            <?php get_template_part('template-parts/svg/linkedin'); ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($sidebar['show_subscribe']) && $sidebar['show_subscribe'] == true) {
                        echo get_template_part('template-parts/global/subscribe');
                    } ?>

                    <?php if (isset($sidebar['professionals']) || isset($sidebar['practice_areas']) || isset($sidebar['industry_groups']) || $sidebar['service_teams']) : ?>
                        <div class="aside-info-wrap">
                            <?php if (isset($sidebar['professionals']) && !empty($sidebar['professionals'])) : ?>
                                <h6><?php echo __('Related Professionals', 'barley-theme'); ?></h6>
                                <ul class="links">
                                    <?php foreach ($sidebar['professionals'] as $professional) : ?>
                                        <li><a href="<?php echo get_the_permalink($professional->ID); ?><?php ?>"><?php echo $professional->post_title; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <?php if (isset($sidebar['practice_areas']) &&!empty($sidebar['practice_areas'])) : ?>
                                <h6><?php echo __('Related Practice Areas', 'barley-theme'); ?></h6>
                                <ul class="links">
                                    <?php foreach ($sidebar['practice_areas'] as $practice) : ?>
                                        <li><a href="<?php echo get_the_permalink($practice->ID); ?>"><?php echo $practice->post_title; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <?php if (isset($sidebar['industry_groups']) && !empty($sidebar['industry_groups'])) : ?>
                                <h6><?php echo __('Related Industry Groups', 'barley-theme'); ?></h6>
                                <ul class="links">
                                    <?php foreach ($sidebar['industry_groups'] as $industry) : ?>
                                        <li><a href="<?php echo get_the_permalink($industry->ID); ?>"><?php echo $industry->post_title; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <?php if (isset($sidebar['service_teams']) && !empty($sidebar['service_teams'])) : ?>
                                <h6><?php echo __('Service Teams', 'barley-theme'); ?></h6>
                                <ul class="links">
                                    <?php foreach ($sidebar['service_teams'] as $service) : ?>
                                        <li><a href="<?php echo get_the_permalink($service->ID); ?>"><?php echo $service->post_title; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </aside>
                <!--article-aside-->
            </div>
        </div>
        <?php if (isset($sidebar['show_resource']) && $sidebar['show_resource'] == true) {
            get_template_part('template-parts/single/related-resources');
        } ?>
    </main>
<?php get_footer(); ?>