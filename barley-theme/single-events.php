<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package barley-theme
 */

get_header();
$main = get_field('event_main_info');
$sidebar = get_field('event_sidebar');
$date = get_event_date($main['date_begin'], $main['date_end'], $main['time_begin'], $main['time_end']); ?>
    <main class="main">
        <div class="container">
            <div class="article-details-heading">
                <div class="holder">
                    <div class="info">
                        <a href="<?php echo get_post_type_archive_link('events'); ?>" class="back-link">
                            <?php get_template_part('template-parts/svg/back-to'); ?>
                            <span><?php echo __('Back to Events', 'barley-theme'); ?></span>
                        </a>
                        <ul class="article-tags">
                            <li><?php echo __('Event', 'barley-theme'); ?></li>
                        </ul>
                        <h3><?php the_title(); ?></h3>
                        <div class="event-details-wrap">
                            <div class="event-details">
                                <?php if (!empty($date['date'])) : ?>
                                    <h4><?php echo $date['date']; ?></h4>
                                <?php endif; ?>
                                <div class="table">
                                    <?php if (!empty($date['time'])) : ?>
                                        <div class="cell">
                                            <div class="title"><?php echo __('time', 'barley-theme'); ?></div>
                                            <strong class="time"><?php echo $date['time']; ?></strong>
                                        </div>
                                    <?php endif; ?>
                                    <div class="cell">
                                        <div class="title"><?php echo __('Location', 'barley-theme'); ?></div>
                                        <?php if (isset($main['type']) && !empty($main['type'])) : ?>
                                            <p><strong><?php echo $main['type']; ?></strong></p>
                                        <?php endif; ?>

                                        <?php if (isset($main['location']) && !empty($main['location'])) : ?>
                                            <address>
                                                <p><?php echo $main['location']; ?></p>
                                            </address>
                                        <?php endif; ?>

                                        <?php if (isset($main['get_direction']) && !empty($main['get_direction'])) : ?>
                                            <a href="<?php echo $main['get_direction']; ?>" class="directions-link" target="_blank">
                                                <span><?php echo __('Get directions', 'barley-theme'); ?></span>
                                                <?php get_template_part('template-parts/svg/get-direction'); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cell">
                                        <?php get_template_part('template-parts/single/share'); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($main['sign_up_event']) && !empty($main['sign_up_event'])) :
                                $sign_up = $main['sign_up_event']; ?>
                                <div class="sign-up-event">
                                    <div class="holder">
                                        <?php if (isset($sign_up['title']) && !empty($sign_up['title'])): ?>
                                            <h4><?php echo $sign_up['title']; ?></h4>
                                        <?php endif; ?>
                                        <?php echo $sign_up['description']; ?>
                                    </div>
                                    <?php if (isset($sign_up['button']['url']) && isset($sign_up['button']['title']) && !empty($sign_up['button']['title'])) :
                                        $target = (isset($sign_up['button']['target']) && !empty($sign_up['button']['target'])) ? 'target="'. $sign_up['button']['target'] .'"' : ''; ?>
                                        <a href="<?php echo $sign_up['button']['url']; ?>" class="button white" <?php echo $target; ?>>
                                            <?php echo __('Sign Up Now', 'barley-theme'); ?>
                                            <?php get_template_part('template-parts/svg/arrow-right-3'); ?>
                                        </a>
                                    <?php endif;?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-holder article-holder">
                <div class="article-content">
                    <?php while (have_posts()):
                        the_post();
                        the_content();
                    endwhile; ?>
                </div>
                <?php if (isset($sidebar['practice_areas']) || isset($sidebar['industry_groups']) || $sidebar['service_teams']) : ?>
                    <aside class="article-aside">
                        <div class="aside-info-wrap">
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
                    </aside>
                    <!--article-aside-->
                <?php endif; ?>
            </div>
        </div>
        <?php if (isset($sidebar['show_news']) && $sidebar['show_news'] == true) {
            get_template_part('template-parts/single/latest-news');
        }
        get_template_part('template-parts/single/upcoming-events'); ?>
    </main>
<?php get_footer(); ?>