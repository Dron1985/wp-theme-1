<?php
$page_id = get_option('page_for_posts');
$url     = get_the_permalink($page_id);
$show    = false;
switch (true) {
    case is_singular('post'):
        $sidebar = get_field('news_sidebar');
        $show    = $sidebar['show_news'];
        $topics  = get_field('news_topics', get_the_ID());
        $category = get_categories_list(get_the_ID(), 'terms');
        if (!empty($category)) {
            $url = add_query_arg(['content-type' => $category[0]], get_the_permalink($page_id));
        }
        break;
    case is_singular('events'):
        $sidebar = get_field('event_sidebar');
        $show    = $sidebar['show_news'];
        break;
    case is_front_page():
    case is_page_template('templates/our-insights.php'):
        $sidebar = get_field('home_news');
        $show    = $sidebar['show_news'];
        break;
    case is_singular('professionals'):
        $field   = get_field('team_additional_info');
        $show    = $field['show_news'];
        $url     = add_query_arg(['attorney' => basename(get_permalink())], get_the_permalink($page_id));
        break;
    case is_singular('capability'):
        $show    = (isset($args['show_news'])) ? $args['show_news'] : false;
        $url     = add_query_arg(['topic' => basename(get_permalink())], get_the_permalink($page_id));
        break;
}

$news = get_latest_news();

if (!empty($news) && $show == true) : ?>
    <section class="latest-news">
        <div class="container">
            <div class="heading-with-button">
                <?php if (is_front_page() || is_page_template('templates/our-insights.php')) : ?>
                    <div class="wrap">
                        <?php echo (isset($sidebar['title']) && !empty($sidebar['title'])) ? '<h2>'.$sidebar['title'].'</h2>' : ''; ?>
                        <?php echo (isset($sidebar['description']) && !empty($sidebar['description'])) ? $sidebar['description'] : ''; ?>
                    </div>
                <?php else:
                    echo (is_singular('capability')) ? '<h2>Related News</h2>' :'<h3>Related News</h3>';
                endif; ?>
                <a href="<?php echo $url; ?>" class="button">
                    <?php if (is_singular('post')) {
                        echo 'View More Resources';
                    } else {
                        echo (is_page_template('templates/our-insights.php')) ? 'View All News' : 'View More News';
                    } ?>
                    <?php set_query_var('color', '#FFFFFF');
                    get_template_part('template-parts/svg/arrow-right-2'); ?>
                </a>
            </div>
            <div class="news-list">
                <?php $i = 1;
                foreach ($news as $p) :
                    $class = ($i > 3 && (is_singular('capability') || is_singular('professionals'))) ? 'hide' : '';
                    set_query_var('post_id', $p->ID);
                    get_template_part('template-parts/archive/item-news', null, array('class' => $class));
                $i++;
                endforeach; ?>
            </div>
        </div>
    </section>
    <!--Latest News-->
<?php endif; ?>