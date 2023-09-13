<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package barley-theme
 */

get_header();
    $page_news = get_option('page_for_posts');
    $authors   = get_field('news_author_list');
    $sidebar   = get_field('news_sidebar');
    $image     = get_featured_img_info('medium-large', get_the_ID());
    $category  = get_categories_list(get_the_ID(), 'list'); ?>
    <main class="main">
        <div class="container">
            <div class="info-details news-details">
                <div class="description">
                    <p>
                        <a href="<?php echo get_the_permalink($page_news); ?>" class="back-link">
                            <?php get_template_part('template-parts/svg/back-to'); ?>
                            <span><?php echo __('Back to News', 'barley-theme'); ?></span>
                        </a>
                    </p>
                    <?php if (!empty($category)) : ?>
                        <ul class="article-tags">
                            <?php echo $category; ?>
                        </ul>
                    <?php endif; ?>
                    <h3><?php the_title(); ?></h3>
                    <div class="published-info">
                        <div>
                            <p class="title"><?php echo __('Published on', 'barley-theme'); ?></p>
                            <strong><?php echo get_the_date('F j, Y'); ?></strong>
                        </div>
                        <div>
                            <?php get_template_part('template-parts/single/share'); ?>
                        </div>
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
                    <hr>
                    <?php if (!empty($authors)) : ?>
                        <div class="speakers">
                            <?php if (get_field('news_author_title')) : ?>
                                <h4><?php echo get_field('news_author_title'); ?></h4>
                            <?php endif; ?>
                            <div class="team-list columns">
                                <?php foreach ($authors as $author) :
                                    $photo = get_featured_img_info('thumbnail', $author->ID);
                                    $field = get_field('contact_info', $author->ID);
                                    $phone = (isset($field['phone']) && !empty($field['phone'])) ? $field['phone'] : '';
                                    $email = (isset($field['email']) && !empty($field['email'])) ? $field['email'] : '';
                                    $linkedin = (isset($field['connect_field']['link_linkedin']) && !empty($field['connect_field']['link_linkedin'])) ? $field['connect_field']['link_linkedin'] : '';?>
                                    <div class="item">
                                        <?php if (!empty($photo['src'])) : ?>
                                            <div class="photo-holder">
                                                <div class="photo" style="background-image: url('<?php echo $photo['src']; ?>')">
                                                    <a href="<?php echo get_the_permalink($author->ID); ?>"></a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="person-contacts">
                                            <?php if (isset($author->post_title)) : ?>
                                                <h6><a href="<?php echo get_the_permalink($author->ID); ?>"><?php echo $author->post_title; ?></a></h6>
                                            <?php endif; ?>

                                            <?php if (!empty($phone) || !empty($email)) : ?>
                                                <ul>
                                                    <li><a href="<?php echo phone_url($phone); ?>"><?php echo $phone; ?></a></li>
                                                    <li><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>
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
                </div>
                <!--article-content-->
                <aside class="article-aside">
                    <?php if (!empty($authors)) : ?>
                        <div class="speakers">
                            <?php if (get_field('news_author_title')) : ?>
                                <h4><?php echo get_field('news_author_title'); ?></h4>
                            <?php endif; ?>
                            <div class="team-list columns">
                                <?php foreach ($authors as $author) :
                                    $photo = get_featured_img_info('thumbnail', $author->ID);
                                    $field = get_field('contact_info', $author->ID);
                                    $phone = (isset($field['phone']) && !empty($field['phone'])) ? $field['phone'] : '';
                                    $email = (isset($field['email']) && !empty($field['email'])) ? $field['email'] : '';
                                    $linkedin = (isset($field['connect_field']['link_linkedin']) && !empty($field['connect_field']['link_linkedin'])) ? $field['connect_field']['link_linkedin'] : '';?>
                                    <div class="item">
                                        <?php if (!empty($photo['src'])) : ?>
                                            <div class="photo-holder">
                                                <div class="photo" style="background-image: url('<?php echo $photo['src']; ?>')">
                                                    <a href="<?php echo get_the_permalink($author->ID); ?>"></a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="person-contacts">
                                            <?php if (isset($author->post_title)) : ?>
                                                <h6><a href="<?php echo get_the_permalink($author->ID); ?>"><?php echo $author->post_title; ?></a></h6>
                                            <?php endif; ?>

                                            <?php if (!empty($phone) || !empty($email)) : ?>
                                                <ul>
                                                    <li><a href="<?php echo phone_url($phone); ?>"><?php echo $phone; ?></a></li>
                                                    <li><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>
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
                                        <li><a href="<?php echo get_the_permalink($professional->ID); ?>"><?php echo $professional->post_title; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <?php if (isset($sidebar['practice_areas']) &&!empty($sidebar['practice_areas'])) : ?>
                                <h6><?php echo __('Related Practice Areas', 'barley-theme'); ?></h6>
                                <ul class="links">
                                    <?php foreach ($sidebar['practice_areas'] as $practice) : ?>
                                        <li><a href="<?php echo get_the_permalink($practice->ID); ?><?php ?>"><?php echo $practice->post_title; ?></a></li>
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

        <?php
        get_template_part('template-parts/single/latest-news');
        get_template_part('template-parts/single/upcoming-events');
        ?>
    </main>
<?php get_footer();