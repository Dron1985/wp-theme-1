<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package barley-theme
 */

get_header();
global $wp_query;
list($search_filter, $found_posts) = get_search_filter();
$message = (!empty(get_search_query()) && $wp_query->found_posts > 0) ? '<strong>'.$wp_query->found_posts.'</strong> results found for <strong>“'.get_search_query().'”</strong>' : '&nbsp;'; ?>
    <main class="main">
        <div class="container">
            <h2><?php echo __('Search', 'barley-theme'); ?></h2>
            <div class="search-form">
                <div class="h6"><?php echo __('Enter search term', 'barley-theme'); ?></div>
                <form class="search-form" role="search" id="search" action="<?php echo home_url( '/' ); ?>" method="get">
                    <div class="input-holder">
                        <input type="text" name="s" placeholder="Search">
                    </div>
                    <button type="submit" class="button">
                        <?php echo __('Search', 'barley-theme'); ?>
                        <?php get_template_part('template-parts/svg/btn-search'); ?>
                    </button>
                    <button class="reset-form"><span><?php echo __('Clear', 'barley-theme'); ?></span></button>
                </form>
            </div>
            <!--search-form-->
            <div class="search-results-wrap">
                <div class="search-filter">
                    <p><?php echo __('Filter by:', 'barley-theme'); ?></p>
                <?php echo get_search_filter(); ?>
                </div>
                <!--search-filter-->
                <?php if (have_posts()) : ?>
                    <div class="search-results">
                        <div class="results">
                            <p><?php echo $message; ?></p>
                        </div>
                        <div class="search-results-list">
                            <?php while (have_posts()) : the_post();
                                global $post;
                                $page_insights = get_page_ID_by_page_template('templates/our-insights.php');
                                $link = get_post_type_archive_link($post->post_type); ?>
                                <div class="item">
                                    <h4><a href="<?php echo get_the_permalink($post->ID); ?>"><?php relevanssi_the_title(); ?></a></h4>
                                    <?php relevanssi_the_excerpt(); ?>
                                    <ul>
                                        <?php if (($post->post_type == 'post' || $post->post_type == 'events' || $post->post_type == 'resources') && !empty($page_insights)) : ?>
                                            <li><a href="<?php get_the_permalink($page_insights); ?>"><?php echo __('Insights', 'barley-theme'); ?></a></li>
                                        <?php endif; ?>
                                        <li><a href="<?php echo $link; ?>"><?php echo $post->post_type; ?></a></li>
                                        <li><?php echo get_the_title($post->ID); ?></li>
                                    </ul>
                                    <a href="<?php echo get_the_permalink($post->ID); ?>" class="button">
                                        <?php echo __('Learn More', 'barley-theme'); ?>
                                        <?php set_query_var('color', 'white');
                                        get_template_part('template-parts/svg/arrow-right-2'); ?>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <?php global $wp_query;
                        if ($wp_query->max_num_pages > 1) : ?>
                            <div class="pagination @@alter-class">
                                <?php pagination(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else:
                    echo '<span class="no-results">No Results found</span>';
                endif; ?>
            </div>
            <!--search-results-->
        </div>
    </main>
<?php get_footer();