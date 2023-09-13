<?php
$show = false;
switch (true) {
    case is_singular('post'):
        $sidebar = get_field('news_sidebar');
        $show    = $sidebar['show_events'];
        break;
    case is_singular('events'):
        $sidebar = get_field('event_sidebar');
        $show    = $sidebar['show_events'];
        break;
    case is_front_page():
    case is_page_template('templates/our-insights.php'):
        $field   = get_field('home_events');
        $show    = $field['show_events'];
        break;
    case is_singular('professionals'):
        $field   = get_field('team_additional_info');
        $show    = $field['show_events'];
        break;
    case is_singular('capability'):
        $show    = (isset($args['show_events'])) ? $args['show_events'] : false;
        break;
}

$class  = (is_front_page()) ? 'upcoming-events-list' : 'events-list';
$events = get_upcoming_events();
if (!empty($events) && $show == true) : ?>
    <section class="upcoming-events">
        <div class="container">
            <div class="heading-with-button">
                <?php if (is_front_page() || is_page_template('templates/our-insights.php')) : ?>
                    <div class="wrap">
                        <?php if (isset($field['title']) && !empty($field['title'])) : ?>
                            <h2><?php echo $field['title']; ?></h2>
                        <?php endif; ?>
                        <?php echo (isset($field['description']) && !empty($field['description'])) ? $field['description'] : ''; ?>
                    </div>
                <?php else:
                    echo (is_singular('professionals') || is_singular('capability')) ? '<h2>Upcoming Events</h2>' : '<h3>Other Upcoming Events</h3>';
                endif; ?>

                <a href="<?php echo get_post_type_archive_link('events'); ?>" class="button">
                    <?php echo __('View All Upcoming Events', 'barley-theme'); ?>
                    <?php set_query_var('color', '#FFFFFF');
                    get_template_part('template-parts/svg/arrow-right-2'); ?>
                </a>
            </div>
            <div class="<?php echo $class; ?>">
                <?php foreach ($events as $event) :
                    set_query_var('post_id', $event);
                    get_template_part('template-parts/archive/item-event');
                endforeach; ?>
            </div>
        </div>
    </section>
    <!--upcoming-events-->
<?php endif; ?>