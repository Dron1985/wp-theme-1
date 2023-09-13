<?php

$prev_link = '<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5L1 4ZM16.0453 4.85355C16.2406 4.65829 16.2406 4.34171 16.0453 4.14645L12.8634 0.964465C12.6681 0.769203 12.3515 0.769203 12.1562 0.964465C11.961 1.15973 11.961 1.47631 12.1562 1.67157L14.9847 4.5L12.1562 7.32843C11.961 7.52369 11.961 7.84027 12.1562 8.03553C12.3515 8.2308 12.6681 8.2308 12.8634 8.03553L16.0453 4.85355ZM1 5L15.6918 5L15.6918 4L1 4L1 5Z" fill="#7A7A7A"></path>
</svg>';

$next_link = '<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5L1 4ZM16.0453 4.85355C16.2406 4.65829 16.2406 4.34171 16.0453 4.14645L12.8634 0.964465C12.6681 0.769203 12.3515 0.769203 12.1562 0.964465C11.961 1.15973 11.961 1.47631 12.1562 1.67157L14.9847 4.5L12.1562 7.32843C11.961 7.52369 11.961 7.84027 12.1562 8.03553C12.3515 8.2308 12.6681 8.2308 12.8634 8.03553L16.0453 4.85355ZM1 5L15.6918 5L15.6918 4L1 4L1 5Z" fill="#7A7A7A"></path>
</svg>';

/**
 * ajax load professionals by location_id
 */
function load_leadership() {
    $return  = array();
    $offset  = $_POST['offset'];
    $next    = $offset + 4;
    $post_id = $_POST['post_id'];

    $args = array(
        'post_type'      => 'professionals',
        'posts_per_page' => 4,
        'post_status'    => 'publish',
        'meta_key'       => 'prof_main_info_last_name',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'offset'         => $offset,
        'meta_query'     => array(
            array(
                'key'     => 'contact_info_office',
                'value'   => $post_id,
                'compare' => 'LIKE'
            )
        ));

    ob_start();
    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $field = get_field('prof_main_info', $post->ID);
            $photo = get_featured_img_info('medium_large', $post->ID); ?>
            <div class="item">
                <?php if (!empty($photo['src'])) : ?>
                    <div class="photo-holder">
                        <div class="photo" style="background-image: url('<?php echo $photo['src']; ?>')">
                            <a href="<?php echo get_the_permalink($post->ID); ?>"></a>
                        </div>
                    </div>
                <?php endif; ?>
                <h5><a href="<?php echo get_the_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></h5>
                <?php if (isset($field['position']) && !empty($field['position'])) : ?>
                    <div class="person-post"><?php echo $field['position']; ?></div>
                <?php endif; ?>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    endif;

    $return['content'] .= ob_get_contents();
    ob_clean();

    if ($query->max_num_pages > 1 && $next < $query->found_posts ) {
        $return['button'] = $next;
    } else {
        $return['button'] = '';
    }

    ob_get_clean();
    wp_send_json($return);
    die();
}
add_action('wp_ajax_load_leadership', 'load_leadership');
add_action('wp_ajax_nopriv_load_leadership', 'load_leadership');


/**
 * ajax load jobs
 */
function load_jobs() {
    ob_start();
    parse_str($_POST['data_attr'], $output);
    $paged = (isset($_POST['paged'])) ? $_POST['paged'] : 1;

    $args = array(
        'post_type'      => 'jobs',
        'posts_per_page' => 5,
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'paged'          => $paged
    );

    if (!empty($output['position']) && $output['position'] != 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'job-position',
                'field'    => 'slug',
                'terms'    => $output['position']
            )
        );
    }

    if (!empty($output['location']) && $output['location'] != 'all') {
        $args['meta_query'] = array(
            array(
                'key'     => 'job_main_info_location',
                'value'   => $output['location'],
                'compare' => '='
            )
        );
    }

    $query = new WP_Query($args);
    if ($query->have_posts()) :
        while ($query->have_posts()): $query->the_post();
            global $post;
            set_query_var('post_id', $post->ID);
            get_template_part('template-parts/archive/item-job');
        endwhile;
    else: ?>
        <span class="no-results"><?php echo __('No Results found', 'barley-theme'); ?></span>
    <?php endif;

    $return['content'] = ob_get_contents();
    ob_clean();

    if ($query->max_num_pages > 1) {
        global $prev_link;
        global $next_link;
        $link = get_post_type_archive_link('jobs');
        $base = $link . '%_%';

        $query_args = array();

        if (!empty($query_args)) {
            $base = add_query_arg($query_args, $base);
        }

        $args = array(
            'base' => $base,
            'format' => '?paged=%#%',
            'total' => $query->max_num_pages,
            'current' => max(1, $paged),
            'mid_size' => 1,
            'prev_text' => $prev_link,
            'next_text' => $next_link,
        );
        $pagination = paginate_links_new($args);
    } else {
        $pagination = '';
    }

    $return['pagination'] = $pagination;
    ob_get_clean();
    wp_reset_postdata();

    wp_send_json($return);
    die();
}
add_action('wp_ajax_load_jobs', 'load_jobs');
add_action('wp_ajax_nopriv_load_jobs', 'load_jobs');

/**
 * ajax load resources
 */
function load_resources() {
    ob_start();
    parse_str($_POST['data_attr'], $output);
    $paged = (isset($_POST['paged'])) ? $_POST['paged'] : 1;
    $search = (isset($_POST['search']) && !empty($_POST['search'])) ? $_POST['search'] : '';

    $args = array(
        'post_type'      => 'resources',
        'posts_per_page' => 9,
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'paged'          => $paged
    );

    if (!empty($output['content-type']) && $output['content-type'] != 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'content-type',
                'field'    => 'slug',
                'terms'    => $output['content-type']
            )
        );
    }

    if (!empty($output['topic']) && $output['topic'] != 'all') {
        $topic = get_page_by_slug($output['topic'], OBJECT, 'capability');
        $args['meta_query'] = array(
            array(
                'key'     => 'resource_main_info_topics',
                'value'   => $topic->ID,
                'compare' => 'LIKE'
            )
        );
    }

    if (!empty($search)) {
        $args['s'] = $search;
    }

    $query = new WP_Query($args);
    if ($query->have_posts()) :
        while ($query->have_posts()): $query->the_post();
            global $post;
            set_query_var('post_id', $post->ID);
            get_template_part('template-parts/archive/item-resource');
        endwhile;
    else: ?>
        <span class="no-results"><?php echo __('No Results found', 'barley-theme'); ?></span>
    <?php endif;

    $return['content'] = ob_get_contents();
    ob_clean();

    if ($query->max_num_pages > 1) {
        global $prev_link;
        global $next_link;
        $link = get_post_type_archive_link('resources');
        $base = $link . '%_%';

        $query_args = array();
        if (!empty($query_args)) {
            $base = add_query_arg($query_args, $base);
        }

        $args = array(
            'base' => $base,
            'format' => '?paged=%#%',
            'total' => $query->max_num_pages,
            'current' => max(1, $paged),
            'mid_size' => 1,
            'prev_text' => $prev_link,
            'next_text' => $next_link,
        );
        $pagination = paginate_links_new($args);
    } else {
        $pagination = '';
    }

    $return['pagination'] = $pagination;
    ob_get_clean();
    wp_reset_postdata();

    wp_send_json($return);
    die();
}
add_action('wp_ajax_load_resources', 'load_resources');
add_action('wp_ajax_nopriv_load_resources', 'load_resources');


/**
 * ajax load events
 */
function load_events() {
    ob_start();
    parse_str($_POST['data_attr'], $output);
    $paged = (isset($_POST['paged'])) ? $_POST['paged'] : 1;
    $search = (isset($_POST['search']) && !empty($_POST['search'])) ? $_POST['search'] : '';

    $args = array(
        'post_type'      => 'events',
        'posts_per_page' => 9,
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'paged'          => $paged
    );

    if (!empty($output['topic']) && $output['topic'] != 'all') {
        $topic = get_page_by_slug($output['topic'], OBJECT, 'capability');
        $args['meta_query'] = array(
            array(
                'key'     => 'event_main_info_topics',
                'value'   => $topic->ID,
                'compare' => 'LIKE'
            )
        );
    }

    if (!empty($search)) {
        $args['s'] = $search;
    }

    $query = new WP_Query($args);
    if ($query->have_posts()) :
        while ($query->have_posts()): $query->the_post();
            global $post;
            set_query_var('post_id', $post->ID);
            get_template_part('template-parts/archive/item-event');
        endwhile;
    else: ?>
        <span class="no-results"><?php echo __('No Results found', 'barley-theme'); ?></span>
    <?php endif;

    $return['content'] = ob_get_contents();
    ob_clean();

    if ($query->max_num_pages > 1) {
        global $prev_link;
        global $next_link;
        $link = get_post_type_archive_link('events');
        $base = $link . '%_%';

        $query_args = array();
        if (!empty($query_args)) {
            $base = add_query_arg($query_args, $base);
        }

        $args = array(
            'base' => $base,
            'format' => '?paged=%#%',
            'total' => $query->max_num_pages,
            'current' => max(1, $paged),
            'mid_size' => 1,
            'prev_text' => $prev_link,
            'next_text' => $next_link,
        );
        $pagination = paginate_links_new($args);
    } else {
        $pagination = '';
    }

    $return['pagination'] = $pagination;
    ob_get_clean();
    wp_reset_postdata();

    wp_send_json($return);
    die();
}
add_action('wp_ajax_load_events', 'load_events');
add_action('wp_ajax_nopriv_load_events', 'load_events');

/**
 * ajax load news
 */
function load_news() {
    ob_start();
    parse_str($_POST['data_attr'], $output);
    $paged = (isset($_POST['paged'])) ? $_POST['paged'] : 1;
    $search = (isset($_POST['search']) && !empty($_POST['search'])) ? $_POST['search'] : '';

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 12,
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'paged'          => $paged
    );

    if (!empty($output['content-type']) && $output['content-type'] != 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $output['content-type']
            )
        );
    }

    if ((isset($output['attorney']) && $output['attorney'] != 'all') || (isset($output['topic']) && $output['topic'] != 'all')) {
        $meta_arr = array('relation' => 'AND');
        if (!empty($output['attorney']) && $output['attorney'] != 'all') {
            $attorney = get_page_by_slug($output['attorney'], OBJECT, 'professionals');
            $meta_attorney = array(
                'key'     => 'news_author_list',
                'value'   => $attorney->ID,
                'compare' => 'LIKE'
            );
            array_push($meta_arr, $meta_attorney);
        }

        if (!empty($output['topic']) && $output['topic'] != 'all') {
            $topic = get_page_by_slug($output['topic'], OBJECT, 'capability');
            $meta_topic = array(
                'key'     => 'news_topics',
                'value'   => $topic->ID,
                'compare' => 'LIKE'
            );
            array_push($meta_arr, $meta_topic);
        }

        $args['meta_query'] = $meta_arr;
    }

    if (!empty($search)) {
        $args['s'] = $search;
    }

    $query = new WP_Query($args);
    if ($query->have_posts()) :
        $i = 1;
        echo '<div class="news-list">';
        while ($query->have_posts()): $query->the_post();
            global $post;
            if ($i == 7) {
                echo '</div>';
                get_template_part('template-parts/global/subscribe', null, ['type' => 'news']);
                echo '<div class="news-list">';
            }

            set_query_var('post_id', $post->ID);
            get_template_part('template-parts/archive/item-news');
        $i++;
        endwhile;
        echo '</div>';
    else: ?>
        <span class="no-results"><?php echo __('No Results found', 'barley-theme'); ?></span>
    <?php endif;

    $return['content'] = ob_get_contents();
    ob_clean();

    if ($query->max_num_pages > 1) {
        global $prev_link;
        global $next_link;
        $page_news = get_option('page_for_posts');
        $link = get_the_permalink($page_news);
        $base = $link . '%_%';

        $query_args = array();
        if (!empty($query_args)) {
            $base = add_query_arg($query_args, $base);
        }

        $args = array(
            'base' => $base,
            'format' => '?paged=%#%',
            'total' => $query->max_num_pages,
            'current' => max(1, $paged),
            'mid_size' => 1,
            'prev_text' => $prev_link,
            'next_text' => $next_link,
        );
        $pagination = paginate_links_new($args);
    } else {
        $pagination = '';
    }

    $return['pagination'] = $pagination;
    ob_get_clean();
    wp_reset_postdata();

    wp_send_json($return);
    die();
}
add_action('wp_ajax_load_news', 'load_news');
add_action('wp_ajax_nopriv_load_news', 'load_news');

/**
 * ajax load team professionals
 */
function load_team() {
    ob_start();
    parse_str($_POST['data_attr'], $output);
    $paged   = (isset($_POST['paged'])) ? $_POST['paged'] : 1;
    (isset($_POST['sort_by']) && !empty($_POST['sort_by'])) ? set_query_var('type', $_POST['sort_by']) : '';

    $args = array(
        'post_type'      => 'professionals',
        'posts_per_page' => 12,
        'post_status'    => 'publish',
        'meta_key'       => 'prof_main_info_last_name',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'paged'          => $paged,
    );

    if ((isset($output['law-school']) && $output['law-school'] != 'all') || (isset($output['college']) && $output['college'] != 'all')){
        $tax_arr = array('relation' => 'AND');

        if (!empty($output['law-school']) && $output['law-school'] != 'all') {
            $tax_school = array(
                'taxonomy' => 'category-school',
                'field'    => 'slug',
                'terms'    => $output['law-school']
            );
            array_push($tax_arr, $tax_school);
        }

        if (!empty($output['college']) && $output['college'] != 'all') {
            $tax_college = array(
                'taxonomy' => 'category-college',
                'field'    => 'slug',
                'terms'    => $output['college']
            );
            array_push($tax_arr, $tax_college);
        }

        $args['tax_query'] = $tax_arr;
    }


    $meta_arr = array('relation' => 'AND');
    $meta_exclude = array(
        'key'     => 'hide_on_listing',
        'value'   => true,
        'compare' => '!='
    );
    array_push($meta_arr, $meta_exclude);

    if (!empty($output['position']) && $output['position'] != 'all') {
        $meta_position = array(
            'key'     => 'prof_main_info_position',
            'value'   => $output['position'],
            'compare' => ''
        );
        array_push($meta_arr, $meta_position);
    }

    if (!empty($output['office']) && $output['office'] != 'all') {
        $meta_office = array(
            'key'     => 'contact_info_office',
            'value'   => $output['office'],
            'compare' => 'LIKE'
        );
        array_push($meta_arr, $meta_office);
    }

    if (!empty($output['practice-area']) && $output['practice-area'] != 'all') {
      //$area = get_page_by_path( $output['practice-area'], OBJECT, 'capability' );
        $area = get_page_by_slug( $output['practice-area'], OBJECT, 'capability' );
        $meta_practice = array(
            'key'     => 'prof_main_info_practice_areas',
            'value'   => $area->ID,
            'compare' => 'LIKE'
        );
        array_push($meta_arr, $meta_practice);
    }

    if (!empty($output['name']) && !isset($_POST['sort_by'])) {
        add_filter( 'posts_where', function ( $where = '' ) {
            global $wpdb;
            parse_str($_POST['data_attr'], $output);
            $value = $output['name'];
            if ( $value ) {
                 $where .= "  AND wp_posts.post_title LIKE '%$value%'";
            }
            return $where;
        });
    }

    $args['meta_query'] = $meta_arr;

    if (isset($_POST['sort_by']) && !empty($_POST['sort_by'])) {
        add_filter( 'posts_where', function ( $where = '' ) {
             global $wpdb;
            $starts_with = esc_sql( $_POST['sort_by']);
            if ( $starts_with ) {
                $where .= "  AND (wp_postmeta.meta_key = 'prof_main_info_last_name' AND SUBSTRING(wp_postmeta.meta_value, 1, 1) LIKE '$starts_with%')";
            }
            return $where;
        });
    }

   /* if (!empty($output['name'])) {
        $args['s'] = $output['name'];
    } */

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()): $query->the_post();
            global $post;
            set_query_var('post_id', $post->ID);
            get_template_part('template-parts/archive/item-professional');
        endwhile;
    else : ?>
        <span class="no-results"><?php echo __('No Results found', 'barley-theme'); ?></span>
    <?php endif;

    $return['content'] = ob_get_contents();
    $return['message'] = ($query->found_posts > 0) ? 'Your search returned <strong>'.$query->found_posts.'</strong> results' : '';
    ob_clean();

    if ($query->max_num_pages > 1 && $query->max_num_pages > $paged) {
        $pagination = $paged+1;
    } else {
        $pagination = 0;
    }

    $return['button'] = $pagination;
    ob_get_clean();
    wp_reset_postdata();

    wp_send_json($return);
    die();
}
add_action('wp_ajax_load_team', 'load_team');
add_action('wp_ajax_nopriv_load_team', 'load_team');