<?php
switch (true) {
    case is_front_page():
    case is_page_template('templates/our-insights.php'):
        $field     = get_field('home_resources');
        $resources = get_resources_by_id();
        $show      = $field['show_resources'];
        $class     = (is_page_template('templates/our-insights.php')) ? 'resources-list' : 'resources-slider';
        break;
    case is_singular('professionals'):
        $resources = get_resources_by_id(get_the_ID());
        $field     = get_field('team_additional_info');
        $show      = $field['show_resources'];
        $class     = 'resources-list';
        break;
    case is_singular('capability'):
        $resources = get_resources_by_id(get_the_ID());
        $show      = (isset($args['show_resources'])) ? $args['show_resources'] : false;
        $class     = 'resources-list';
        break;
    default:
        $resources = get_resources_by_id(get_the_ID());
        $show      = true;
        $class     = 'resources-list';
}
if (is_singular('capability')) {
    $url = add_query_arg(['topic' => basename(get_permalink())], get_post_type_archive_link('resources'));
} elseif (is_singular('professionals')) {
    $url = add_query_arg(['attorney' => basename(get_permalink())], get_post_type_archive_link('resources'));
} else {
    $url = get_post_type_archive_link('resources');
}

if (!empty($resources) && $show == true) : ?>
    <section class="resources">
        <div class="container">
            <div class="heading-with-button">
                <?php if (is_front_page() || is_page_template('templates/our-insights.php')) : ?>
                    <div class="wrap">
                        <?php echo (isset($field['title']) && !empty($field['title'])) ? '<h2>'.$field['title'].'</h2>' : ''; ?>
                        <?php echo (isset($field['description']) && !empty($field['description'])) ? $field['description'] : ''; ?>
                    </div>
                <?php else :
                    echo (is_singular('professionals')) ? '<h3>Related Resources</h3>' : '<h2>Related Resources</h2>';
                endif; ?>

                <a href="<?php echo $url; ?>" class="button">
                    <?php if (is_front_page() ) {
                        echo 'See All Resources';
                    } else {
                        echo (is_singular('professionals') || is_singular('capability') || is_singular('resources')) ? 'View More Resources' : 'View All Resources';
                    } ?>
                    <?php set_query_var('color', '#FFFFFF');
                    get_template_part('template-parts/svg/arrow-right-2'); ?>
                </a>
            </div>
            <div class="<?php echo $class; ?>">
                <?php $i = 1;
                foreach ($resources as $resource) :
                    $class = ($i > 3 && (is_singular('capability') || is_singular('professionals'))) ? 'hide' : '';
                    set_query_var('post_id', $resource);
                    get_template_part('template-parts/archive/item-resource',null, array('class' => $class));
                $i++;
                endforeach; ?>
            </div>
        </div>
    </section>
    <!--resources-->
<?php endif; ?>