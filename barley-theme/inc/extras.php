<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package barley-theme
 */

/**
 * Get page id - by template
 *
 */
function get_page_ID_by_page_template($template_name){
    global $wpdb;
    $page_ID = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = '$template_name' AND meta_key = '_wp_page_template'");
    return $page_ID;
}

/**
 * Phone URL
 *
 * @param string $phone_number , ex: (555) 123-4568
 * @return string $phone_url, ex: tel:5551234568
 */
function phone_url($phone_number = false){
    $phone_number = preg_replace("/[^0-9]/", "", $phone_number);
    return esc_url('tel:' . $phone_number);
}

/**
 * Get featured image info
 *
 */
function get_featured_img_info($img_size = 'large', $post_id = false){
    $post_id = $post_id ?: get_the_ID();
    $thumb_id = get_post_thumbnail_id($post_id);
    $img_src = wp_get_attachment_image_url($thumb_id, $img_size);
    $alt = (is_singular('professionals') && !empty($post_id)) ? get_the_title($post_id) : get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
    return array('src' => $img_src, 'alt' => $alt);
}

/**
 * Get custom excerpt
 *
 */
function get_excerpt_by_id($post_id){
    $the_post = get_post($post_id);
    $the_excerpt = $the_post->post_excerpt;
    $the_excerpt = !empty($the_excerpt) ? $the_excerpt : $the_post->post_content;
    $excerpt_length = 50; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images

    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

    if (count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
    endif;

    return $the_excerpt;
}

/**
 * get custom excertp length
 */
function do_excerpt($string, $limit){
    $string = strip_tags($string, '<br>');
    $count = strlen($string);
    $string = substr($string, 0, $limit);

    if ($count > $limit) {
        $string .= '...';
    }
    echo $string;
}

/**
 * Get author full name
 *
 */
function get_author_full_name(){
    global $post;
    $user_info = get_userdata($post->post_author);
    $nickname = $user_info->display_name;
    $full_name = $user_info->first_name . ' ' . $user_info->last_name;
    return $full_name ?: $nickname;
}

/**
 * Generate link html by ACF field link
 *
 */
function html_link_by_ACF_Link($field, $class = '', $title_wrap = '', $add_html = ''){
    $link_html = '';
    $url = isset($field['url']) && !empty($field['url']) ? $field['url'] : '';
    $title = isset($field['title']) && !empty($field['title']) ? $field['title'] : '';
    $target_html = isset($field['target']) && $field['target'] == '_blank' ? 'target="_blank"' : '';
    $class_html = !empty($class) ? 'class="' . $class . '"' : '';
    $title = !empty($title_wrap) ? '<' . $title_wrap . '>' . $title . '</' . $title_wrap . '>' : $title;
    if (!empty($url)) {
        $link_html = '<a href="' . esc_url($url) . '" ' . $target_html . ' ' . $class_html . '>' . $title . $add_html . '</a>';
    }
    return $link_html;
}

/**
 * Recursively remove ALL values that evaluate to false including empty arrays
 *
 * @param $input
 * @return array
 */
function array_trim($input)
{
    return is_array($input) ? array_filter($input,
        function (&$value) {
            return $value = array_trim($value);
        }
    ) : $input;
}


function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) {
    global $wpdb;
    $page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'", $page_slug, $post_type ) );
    if ( $page )
        return get_post($page, $output);
    return null;
}


/**
 * get categories list by post id
 */
function get_categories_list($post_id, $type = false){
    $post_type = get_post_type($post_id);

    switch ($post_type) {
        case 'post':
            $categories = get_the_terms($post_id, 'category');
            break;
        case 'resources':
            $categories = get_the_terms($post_id, 'content-type');
            break;
        default:
            $categories = '';
    }

    if ($categories) {
        foreach ($categories as $category) {
            if ($type == 'link') {
                $arr_term[] = '<a href="' . get_term_link($category->term_id) . '">' . $category->name . '</a>';
            } elseif ($type == 'list') {
                $arr_term[] = '<li>' . $category->name . '</li>';
            } elseif ($type == 'terms') {
                $arr_term[] = $category->slug;
            } else {
                $arr_term[] = $category->name;
            }
        }
        if ($type == 'terms') {
            $arr = $arr_term;
        } else {
            $arr = ($type == 'label') ? implode(", ", $arr_term) : implode(" ", $arr_term) ;
        }

    } else {
        $arr = '';
    }

    return $arr;
}

/**
 * get topics list by post id
 */
function get_topics_list($post_id){
    $post_type = get_post_type($post_id);

    switch ($post_type) {
        case 'events':
            $field = get_field('event_main_info', $post_id);
            $topics = $field['topics'];
            break;
        case 'resources':
            $field = get_field('resource_main_info', $post_id);
            $topics = $field['topics'];
            break;
        default:
            $topics = '';
    }

    if (!empty($topics)) {

        if (is_front_page()) {
            $arr = $topics[0]->post_title;
        } else {
            foreach ($topics as $topic) {
                $arr[] = ($post_type == 'resources') ? '<li>'.$topic->post_title.'</li>' : $topic->post_title;
            }

            $arr = ($post_type == 'resources') ? $arr : implode(", ", $arr);
        }

    } else {
        $arr = '';
    }

    return $arr;
}

/**
 * get all locations
 */
function get_locations() {
    $arr = array();
    $args = array(
        'post_type'      => 'locations',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'order'          => 'ASC',
        'orderby'        => 'title'
    );

    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $arr[] = $post;
        endwhile;
        wp_reset_postdata();
    endif;

    return $arr;
}

/**
 * get all positions posttype professionals
 */
function get_positions() {
    $arr_terms = array();
    $filters = get_field('fields_professionals', 'option');
    if (!empty($filters['exclude_position'])) {
        foreach ($filters['exclude_position'] as $category) {
            $arr_terms[] = $category['category'];
        }
    }

    $arr = array();
    $args = array(
        'post_type'      => 'professionals',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'order'          => 'ASC',
        'orderby'        => 'title'
    );

    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post();
            global $post;

            $field = get_field('prof_main_info', $post->ID);
            if (isset($field['position']) && !empty($field['position'])) {
                if (!in_array($field['position'], $arr_terms)) {
                    $arr[] = $field['position'];
                }
            }
        endwhile;
        wp_reset_postdata();
    endif;

    return array_unique($arr);
}


/**
 * get all practice areas
 */
function get_practice_areas(){
    $arr = array();
    $args = array(
        'post_type'      => 'capability',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC');

    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $arr[] = $post;
        endwhile;
        wp_reset_postdata();
    endif;

    return $arr;
}


/**
 * get latest news
 */
function get_latest_news($page_id = false, $type = false) {
    $post_id = (!empty($page_id)) ? $page_id : get_the_ID();

    if (is_singular('professionals') || is_singular('capability')) {
        $count = -1;
    } else {
        if (!empty($page_id)) {
            $count = -1;
        } else {
            $count = (is_page_template('templates/our-insights.php')) ? 6 : 3;
        }
    }

    $arr = array();
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'order'          => 'DESC'
    );

    if (is_singular('professionals') || (!empty($page_id) && !empty($type) && $type == 'professionals')) {
        $args['meta_query'] = array(
            array(
                'key'     => 'news_author_list',
                'value'   => $post_id,
                'compare' => 'LIKE'
            )
        );
    }

    if (is_singular('capability') || (!empty($page_id) && !empty($type) && $type == 'capability')) {
        $args['meta_query'] = array(
            array(
                'key'     => 'news_topics',
                'value'   => $post_id,
                'compare' => 'LIKE'
            )
        );
    }

    if (is_singular('events')) {
        $field = get_field('event_main_info', get_the_ID());
        if (!empty($field['topics'])) {
            $meta_arr = array('relation' => 'OR');
            foreach ($field['topics'] as $topic) {
                $arr_ids = array(
                    'key'     => 'news_topics',
                    'value'   => $topic->ID,
                    'compare' => 'LIKE'
                );
                array_push($meta_arr, $arr_ids);
            }
            $args['meta_query'] = $meta_arr;
        }
    }

    if (is_singular('post') && get_field('news_topics', $post_id)) {
        $meta_arr = array('relation' => 'OR');
        $topics = get_field('news_topics', $post_id);
        foreach ($topics as $topic) {
            $arr_ids = array(
                'key'     => 'news_topics',
                'value'   => $topic->ID,
                'compare' => 'LIKE'
            );
            array_push($meta_arr, $arr_ids);
        }
        $args['meta_query'] = $meta_arr;
    }

    if (is_singular('post')) {
        $args['post__not_in'] = array($post_id);
    }

    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $arr[] = $post;
        endwhile;
        wp_reset_postdata();
    endif;

    return $arr;
}

/**
 * get capabilities by term_id
 */
function get_capability_by_term($term){
    $arr = array();
    $args = array(
        'post_type'      => 'capability',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'order'          => 'ASC',
        'orderby'        => 'title',
        'tax_query' => array(
        array(
            'taxonomy' => 'capability-category',
            'field'    => 'slug',
            'terms'    => $term
        )
    ));

    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $arr[] = $post;
        endwhile;
    endif;

    return $arr;
}


/**
 * get leadership by page id
 */
function get_leadership_by_id($page_id = false, $type = false) {// var_dump($page_id);
    $arr = array();
    $args = array(
        'post_type'      => 'professionals',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_key'       => 'prof_main_info_last_name',
        'orderby'        => 'meta_value',
        'order'          => 'ASC');

    if (!empty($page_id)) {
        $field = (is_singular('capability') || (!empty($type) && $type == 'capability')) ? 'prof_main_info_practice_areas' : 'contact_info_office';

        $args['meta_query'] = array(
            array(
                'key'     => $field,
                'value'   => $page_id,
                'compare' => 'LIKE'
            )
        );
    }

    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $arr[] = array('id' => $post->ID, 'slug' => $post->post_name, 'title' => $post->post_title);
        endwhile;
        wp_reset_postdata();
    endif;

    return $arr;
}


/**
 * get resources by page id
 */
function get_resources_by_id($page_id = false, $type = false) {
    if (is_front_page()) {
        $count = 7;
    } elseif (is_singular('professionals') || is_singular('capability') || !empty($page_id) && !is_singular('resources')){
        $count = -1;
    } else {
        $count = (is_page_template('templates/our-insights.php')) ? 6 : 3;
    }

    $arr = array();
    $args = array(
        'post_type'      => 'resources',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'order'          => 'DESC'
    );

    if (is_singular('professionals') || (!empty($page_id) && !empty($type) && $type == 'professionals')) {
        $args['meta_query'] = array(
            array(
                'key'     => 'resource_sidebar_professionals',
                'value'   => $page_id,
                'compare' => 'LIKE'
            )
        );
    }

    if (is_singular('capability') || (!empty($page_id) && !empty($type) && $type == 'capability')) {
        $args['meta_query'] = array(
            array(
                'key'     => 'resource_main_info_topics',
                'value'   => $page_id,
                'compare' => 'LIKE'
            )
        );
    }

    if (is_singular('resources')) {
        $args['post__not_in'] = array($page_id);
    }

    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $arr[] = $post->ID;
        endwhile;
        wp_reset_postdata();
    endif;

    return $arr;
}

/**
 * get resources by page id
 */
function get_upcoming_events() {
    $date = new DateTime('now');
    $arr  = array();
    $args = array(
        'post_type'      => 'events',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'order'          => 'ASC',
        'meta_key'       => 'event_main_info_date_begin',
        'orderby'        => 'meta_value_num',
        'meta_query'     => array(
            array(
                'key'     => 'event_main_info_date_begin',
                'value'   => $date->format('Y-m-d'),
                'compare' => '>='
            )
        )
    );

    if (is_singular('professionals')) {
        add_filter( 'posts_where', function ( $where = '' ) {
            global $wpdb;
            $post_id = get_the_ID();
            //$where .= " AND {$wpdb->posts}.post_content LIKE '%speakers_field_professionals%' ";
            $where .= " AND {$wpdb->posts}.post_content LIKE '%speakers_field_professionals%'and {$wpdb->posts}.post_content LIKE '%{$post_id}%'";
            return $where;
        });
    }

    if (is_singular('events')) {
        $args['post__not_in'] = array(get_the_ID());
    }

    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $arr[] = $post->ID;
        endwhile;
        wp_reset_postdata();
    endif;

    return $arr;
}


/**
 *  get alerts list
 */
function get_alerts_list(){
    $arr = array();
    $args = array(
        'post_type'      => array('post', 'events', 'resources'),
        'posts_per_page' => 10,
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => 'homepage_alert',
                'value'   => true,
                'compare' => 'LIKE'
            )
        ));

    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $arr[] = $post->ID;
        endwhile;
        wp_reset_postdata();
    endif;

    return $arr;
}

/**
 *
 */
function get_alert_type($post_id){
    $post_type = get_post_type($post_id);

    switch ($post_type) {
        case 'events':
            $title = 'Event Alert';
            break;
        case 'resources':
            $title = 'Resource Alert';
            break;
        case 'post':
            $title = 'News Alert';
            break;
        default:
            $title = '';
    }

    return $title;
}

/**
 * format bytes to other size
 */
function formatSizeUnits($bytes){
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes/1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes/1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes/1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

/**
 * Custom pagination
 *
 */
if (!function_exists('paginate_links_new')) {
    function paginate_links_new($args = '')
    {
        global $wp_query, $wp_rewrite;

        // Setting up default values based on the current URL.
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $url_parts = explode('?', $pagenum_link);

        // Get max pages and current page out of the current query, if available.
        $total = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
        $current = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

        // Append the format placeholder to the base URL.
        $pagenum_link = trailingslashit($url_parts[0]) . '%_%';

        // URL base depends on permalink settings.
        $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

        $defaults = array(
            'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
            'format' => $format, // ?page=%#% : %#% is replaced by the page number
            'total' => $total,
            'current' => $current,
            'aria_current' => 'page',
            'show_all' => false,
            'prev_next' => true,
            'prev_text' => __('&laquo; Previous'),
            'next_text' => __('Next &raquo;'),
            'end_size' => 1,
            'mid_size' => 2,
            'type' => 'plain',
            'add_args' => array(), // array of query args to add
            'add_fragment' => '',
            'before_page_number' => '',
            'after_page_number' => '',
        );

        $args = wp_parse_args($args, $defaults);

        if (!is_array($args['add_args'])) {
            $args['add_args'] = array();
        }

        // Merge additional query vars found in the original URL into 'add_args' array.
        if (isset($url_parts[1])) {
            // Find the format argument.
            $format = explode('?', str_replace('%_%', $args['format'], $args['base']));
            $format_query = isset($format[1]) ? $format[1] : '';
            wp_parse_str($format_query, $format_args);

            // Find the query args of the requested URL.
            wp_parse_str($url_parts[1], $url_query_args);

            // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
            foreach ($format_args as $format_arg => $format_arg_value) {
                unset($url_query_args[$format_arg]);
            }

            $args['add_args'] = array_merge($args['add_args'], urlencode_deep($url_query_args));
        }

        // Who knows what else people pass in $args
        $total = (int)$args['total'];
        if ($total < 2) {
            return;
        }
        $current = (int)$args['current'];
        $end_size = (int)$args['end_size']; // Out of bounds?  Make it the default.
        if ($end_size < 1) {
            $end_size = 1;
        }
        $mid_size = (int)$args['mid_size'];
        if ($mid_size < 0) {
            $mid_size = 2;
        }

        $add_args = $args['add_args'];
        $r = '';
        $page_links = array();
        $dots = false;

        if ($args['prev_next'] && $current) :
            $link = str_replace('%_%', 2 == $current ? '' : $args['format'], $args['base']);
            $link = str_replace('%#%', $current - 1, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $link .= $args['add_fragment'];

            if (1 < $current) {
                $page_links[] = sprintf(
                    '<a class="prev previouspostslink page-numbers" href="%s" data-num="' . ($current - 1) . '" title="Page ' . ($current - 1) . '">%s</a>',
                    /**
                     * Filters the paginated links for the given archive pages.
                     *
                     * @param string $link The paginated link URL.
                     * @since 3.0.0
                     *
                     */
                    esc_url(apply_filters('paginate_links', $link)),
                    $args['prev_text']
                );
            } elseif ($current == 1) {
                $page_links[] = sprintf(
                    '<a class="prev previouspostslink page-numbers disabled">%s</a>',
                    $args['prev_text']
                );
            }
        endif;

        for ($n = 1; $n <= $total; $n++) :
            if ($n == $current) :
                $page_links[] = sprintf(
                    '<span aria-current="%s" class="page-numbers current">%s</span>',
                    esc_attr($args['aria_current']),
                    $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number']
                );

                $dots = true;
            else :
                if ($args['show_all'] || ($n <= $end_size || ($current && $n >= $current - $mid_size && $n <= $current + $mid_size) || $n > $total - $end_size)) :
                    $link = str_replace('%_%', 1 == $n ? '' : $args['format'], $args['base']);
                    $link = str_replace('%#%', $n, $link);
                    if ($add_args) {
                        $link = add_query_arg($add_args, $link);
                    }
                    $link .= $args['add_fragment'];

                    $page_links[] = sprintf(
                        '<a class="page-numbers" href="%s" data-num="' . $n . '" title="Page ' . $n . '">%s</a>',
                        /** This filter is documented in wp-includes/general-template.php */
                        esc_url(apply_filters('paginate_links', $link)),
                        $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number']
                    );

                    $dots = true;
                elseif ($dots && !$args['show_all']) :
                    $page_links[] = '<span class="page-numbers dots">' . __('&hellip;') . '</span>';

                    $dots = false;
                endif;
            endif;
        endfor;

        if ($args['prev_next'] && $current) :
            $link = str_replace('%_%', $args['format'], $args['base']);
            $link = str_replace('%#%', $current + 1, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $link .= $args['add_fragment'];

            if ($current < $total) {
                $page_links[] = sprintf(
                    '<a class="next nextpostslink page-numbers" href="%s" data-num="' . ($current + 1) . '" title="Page ' . ($current + 1) . '">%s</a>',
                    /** This filter is documented in wp-includes/general-template.php */
                    esc_url(apply_filters('paginate_links', $link)),
                    $args['next_text']
                );
            } elseif ($current == $total) {
                $page_links[] = sprintf(
                    '<a class="next nextpostslink page-numbers disabled">%s</a>',
                    $args['next_text']
                );
            }
        endif;

        switch ($args['type']) {
            case 'array':
                return $page_links;

            case 'list':
                $r .= "<ul class='page-numbers'>\n\t<li>";
                $r .= join("</li>\n\t<li>", $page_links);
                $r .= "</li>\n</ul>\n";
                break;

            default:
                $r = '<div class="wp-pagenavi">' . join("\n", $page_links) . '</div>';
                break;
        }

        return $r;
    }
}

if (!function_exists('pagination')) {
    function pagination($paged = '', $max_page = '')
    {
        global $wp_query;
        $big = 999999999;
        if (!$paged)
            $paged = get_query_var('paged');
        if (!$max_page)
            $max_page = $wp_query->max_num_pages;
        $result = paginate_links_new(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, $paged),
            'total' => $max_page,
            'mid_size' => 1,
            'prev_text' => '',
            'next_text' => '',
        ));
        $result = preg_replace('~page/1/?([\'"])~', '\1', $result);
        echo $result;
    }
}


/**
 * get event date
 */
function get_event_date($date_1 = false, $date_2 = false, $time_1 = false, $time_2 = false, $type = false){
    $arr = array();

    if (!empty($date_1)) {
        $date_begin  = DateTime::createFromFormat('Ymd', $date_1);
        $year_begin  = $date_begin->format('Y');
        $month_begin = $date_begin->format('M');
        $day_begin   = $date_begin->format('d');
        $list_date1  = '<div class="month">'.$month_begin.'</div><div class="date">'.$day_begin.'</div>';
    }
    if (!empty($date_2)) {
        $date_end    = DateTime::createFromFormat('Ymd', $date_2);
        $year_end    = $date_end->format('Y');
        $month_end   = $date_end->format('M');
        $day_end     = $date_end->format('d');
        $list_date2  = '<div class="month">'.$month_end.'</div><div class="date">'.$day_end.'</div>';
    }

    if (isset($date_begin) && isset($date_end)) {
        if ($type == 'listing') {
            $list_date1 .= (!empty($time_1)) ? '<div class="time">'.$time_1.'</div>' : '';
            $list_date2 .= (!empty($time_2)) ? '<div class="time">'.$time_2.'</div>' : '';
            $arr['date'] = '<div class="star-date">'.$list_date1.'</div><div class="end-date">'.$list_date2.'</div>';
        } elseif ($type == 'home') {
            if ($month_begin == $month_end) {
                $arr['date'] = $date_begin->format('F').' '.$day_begin.' - '.$day_end.', '.$year_begin;
            } else {
                $arr['date'] = $date_begin->format('F d, Y').' - '.$date_end->format('F d, Y') ;
            }
        } else {
            $arr['date'] = $date_begin->format('l, F d') .' - '. $date_end->format('l, F d');
            $arr['time'] = (!empty($time_1) && !empty($time_2)) ? $time_1.' - '.$time_2 : $time_1;
        }
    } elseif (isset($date_begin) ) {
        if ($type == 'listing') {
            $list_date1 .= (!empty($time_1) && !empty($time_2)) ? '<div class="time">'.$time_1.'</div> - <div class="time">'.$time_2.'</div>' : '<div class="time">'.$time_1.'</div>';
            $arr['date'] = '<div class="star-date">' .$list_date1. '</div>';
        } elseif ($type == 'home') {
            $arr['date'] = $date_begin->format('F d, Y');
        } else {
            $arr['date'] = $date_begin->format('l, F d');
            $arr['time'] = (!empty($time_1) && !empty($time_2)) ? $time_1.' - '.$time_2 : $time_1;
        }
    }

    return $arr;
}

/**
 * get parent page and children pages by id
 */
function get_areas_list($page_id, $type = false){
    $arr = array();
    $ancestors = get_ancestors($page_id, 'capability');

    if (!empty($ancestors)) {
        $arr['main'] = array('title' => get_the_title($ancestors[0]), 'id' => $ancestors[0]);
    }

    if (is_singular('capability') || (!empty($type) && $type == 'capability')) {
        $parent_id = (!empty($ancestors)) ? $ancestors[0] : $page_id;
    } else {
        $parent_id = $page_id;
    }

    $childrens = get_children( [
        'post_parent' => $parent_id,
        'post_type'   => 'capability',
        'numberposts' => -1,
        'post_status' => 'publish',
        'order'       => 'ASC',
        'orderby'     => 'title'
    ] );

    if (!empty($childrens)){
        foreach( $childrens as $children ){
            $arr['focus_areas'][] = array('title' => $children->post_title, 'id' => $children->ID);
        }
    }

    return $arr;
}


/**
 * disable Gutenberg editor for ids
 */
function disable_gutenberg_page_ids( $use_block_editor, $post ) {

    $page_blog = get_option('page_for_posts');
    if ($post->ID == $page_blog) {
        return false;
    }
    return $use_block_editor;
}
add_filter( 'use_block_editor_for_post', 'disable_gutenberg_page_ids', 10, 2 );


/**
 * Hide predefined Gutenberg patterns
 *
 */
add_filter('block_editor_settings', 'disable_block_patterns', 100);
function disable_block_patterns($settings)
{
    unset($settings['__experimentalBlockPatterns']);
    return $settings;
}

/**
 * Get speakers list by id
 */
function get_speakers_events($post_id)
{
    if (function_exists('get_field')) {
        $post      = get_post($post_id);
        $blocks    = parse_blocks($post->post_content);

        foreach($blocks as $block){
            if (isset($block['attrs']['name']) && $block['attrs']['name'] == 'acf/speakers-block') {
                if ($block['attrs']['data']['speakers_field_type'] == 'custom') {
                    $count = $block['attrs']['data']['speakers_field_speakers'];
                    for ($i = 0; $i < $count; $i++) {
                        $field = 'speakers_field_speakers_'.$i.'_photo';
                        $photo_id = $block['attrs']['data'][$field];
                        $photo = wp_get_attachment_image_url($photo_id, 'thumbnail');
                        if (!empty($photo)) {
                            echo '<div class="photo" style="background-image: url('.$photo.')"></div>';
                        }
                    }
                } else {
                    $professionals = $block['attrs']['data']['speakers_field_professionals'];
                    if (!empty($professionals)) {
                        foreach ($professionals as $professional) {
                            $photo = get_featured_img_info('thumbnail', $professional);
                            if (!empty($photo['src'])) {
                                echo '<div class="photo" style="background-image: url('.$photo['src'].')"></div>';
                            }
                        }
                    }
                }
            }
        }
    }
}


/**
 * Get speakers list by id
 */
function get_accordion_info($post_id)
{
    if (function_exists('get_field')) {
        $post      = get_post($post_id);
        $blocks    = parse_blocks($post->post_content);

        foreach($blocks as $block){
            if (isset($block['attrs']['name']) && $block['attrs']['name'] == 'acf/accordion-block') {
                $count = $block['attrs']['data']['accordion_field'];
                for ($i = 0; $i < $count; $i++) {
                    $field_title = 'accordion_field_'.$i.'_title';
                    $field_desc = 'accordion_field_'.$i.'_description';
                    $arr[] = array('title' => $block['attrs']['data'][$field_title], 'description' => $block['attrs']['data'][$field_desc]);
               }

                return $arr;
            }
        }
    }
}


/**
 * ACF Block Helper class
 * Get all fields of block by block name
 */
class BlockHelper
{
    var $block_name;
    var $post_id;

    function __construct($block_name, $post_id)
    {
        $this->block_name = $block_name;
        $this->post_id = $post_id;

    }

    public function getBlockFields()
    {
        $post = get_post($this->post_id);

        if (!$post) return false;

        $blocks = parse_blocks($post->post_content);

        foreach ($blocks as $block) {
            if ($block['attrs']['name'] !== $this->block_name) continue;

            acf_setup_meta($block['attrs']['data'], $block['attrs']['id'], true);

            $fields = get_fields();

            acf_reset_meta($block['attrs']['id']);

            return $fields;

        }

        return false;
    }
}


/**
 * Register new ACF block types
 */
add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types(){
    if (function_exists('acf_register_block_type')) {

        //Global hero section
        acf_register_block_type(array(
            'name' => 'hero-section',
            'title' => __('Hero section'),
            'description' => '',
            'render_template' => 'template-parts/global/hero-section.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => false, 'align' => false),
            'keywords' => array('hero', 'block'),
            'post_types' => array('page')
        ));

        //Homepage additional section
        acf_register_block_type(array(
            'name' => 'home-main-block',
            'title' => __('Main block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/home/main-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => false, 'align' => false),
            'keywords' => array('main', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'home-info-block',
            'title' => __('Home info block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/home/info-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('home', 'info', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'home-events-block',
            'title' => __('Upcoming Events block'),
            'description' => '',
            'render_template' => 'template-parts/single/upcoming-events.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => false, 'align' => false),
            'keywords' => array('upcoming', 'events', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'home-about-block',
            'title' => __('We are Barley Snyder'),
            'description' => '',
            'render_template' => 'template-parts/blocks/home/about-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('we', 'are', 'barley', 'snyder'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'home-news-block',
            'title' => __('Latest News block'),
            'description' => '',
            'render_template' => 'template-parts/single/latest-news.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => false, 'align' => false),
            'keywords' => array('latest', 'news', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'home-resources-block',
            'title' => __('Best Practice block'),
            'description' => '',
            'render_template' => 'template-parts/single/related-resources.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => false, 'align' => false),
            'keywords' => array('best', 'practice', 'block'),
            'post_types' => array('page')
        ));

        //Careers additional section
        acf_register_block_type(array(
            'name' => 'info-block',
            'title' => __('Info block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/careers/info-blocks.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('info', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'benefits-block',
            'title' => __('Benefits block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/careers/benefits.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('benefits', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'banner-block',
            'title' => __('Banner block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/careers/banner.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('banner', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'contact-block',
            'title' => __('Contact block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/careers/contact-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => false, 'align' => false),
            'keywords' => array('contact', 'block'),
            'post_types' => array('page')
        ));

        //Contact Us additional section
        acf_register_block_type(array(
            'name' => 'professionals-block',
            'title' => __('Our professionals'),
            'description' => '',
            'render_template' => 'template-parts/blocks/contact/professionals-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('our', 'professionals', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'contact-info-block',
            'title' => __('Accounts Payable/Law Pay'),
            'description' => '',
            'render_template' => 'template-parts/blocks/contact/contact-info.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('accounts', 'payable', 'law', 'pay'),
            'post_types' => array('page')
        ));

        //Contact Us additional section
        acf_register_block_type(array(
            'name' => 'media-block',
            'title' => __('Media block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/about/media-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('media', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'capabilities-block',
            'title' => __('Capabilities block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/about/capabilities-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('capabilities', 'block'),
            'post_types' => array('page')
        ));

        //Professionals additional section
        acf_register_block_type(array(
            'name' => 'video-block',
            'title' => __('Video block'),
            'description' => '',
            'render_template' => 'template-parts/single/video-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('video', 'block'),
            'post_types' => array('professionals', 'resources')
        ));

        acf_register_block_type(array(
            'name' => 'accordion-block',
            'title' => __('Accordion block'),
            'description' => '',
            'render_template' => 'template-parts/single/accordion-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('accordion', 'block'),
            'post_types' => array('professionals')
        ));

        //Job additional section
        acf_register_block_type(array(
            'name' => 'job-benefits-block',
            'title' => __('Job benefits block'),
            'description' => '',
            'render_template' => 'template-parts/single/job-benefits.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('job', 'benefits', 'block'),
            'post_types' => array('jobs')
        ));

        //Management Team additional section
        acf_register_block_type(array(
            'name' => 'bio-quote-block',
            'title' => __('Top Bio + quote block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/management-team/bio-quote-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('top', 'bio', 'quote', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'leadership-team-block',
            'title' => __('Leadership team block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/management-team/leadership-team.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('leadership', 'team', 'block'),
            'post_types' => array('page')
        ));

        //Your Life at Barley Snyder additional section
        acf_register_block_type(array(
            'name' => 'testimonials-block',
            'title' => __('Testimonials block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/your-life/testimonials-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('testimonials', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'insurance-retirement',
            'title' => __('Insurance and retirement plans'),
            'description' => '',
            'render_template' => 'template-parts/blocks/your-life/insurance-retirement.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('insurance', 'and', 'retirement', 'plans'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'development-programs',
            'title' => __('Professional Development Programs'),
            'description' => '',
            'render_template' => 'template-parts/blocks/your-life/development-programs.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => false, 'align' => false),
            'keywords' => array('professional', 'development', 'programs'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'work-benefits-block',
            'title' => __('Work life benefits block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/your-life/work-life-benefits.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('work', 'life', 'benefits', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'join-team-block',
            'title' => __('Join our team block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/your-life/join-team-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('join', 'our', 'team', 'block'),
            'post_types' => array('page')
        ));

        //Resources additional section
        acf_register_block_type(array(
            'name' => 'audio-block',
            'title' => __('Audio block'),
            'description' => '',
            'render_template' => 'template-parts/single/audio-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('audio', 'block'),
            'post_types' => array('resources')
        ));

        acf_register_block_type(array(
            'name' => 'quote-block',
            'title' => __('Quote block'),
            'description' => '',
            'render_template' => 'template-parts/single/quote-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('custom', 'quote', 'block'),
            'post_types' => array('resources', 'post')
        ));

        acf_register_block_type(array(
            'name' => 'slider-block',
            'title' => __('Slider block'),
            'description' => '',
            'render_template' => 'template-parts/single/slider-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => false, 'align' => false),
            'keywords' => array('custom', 'quote', 'block'),
            'post_types' => array('resources', 'post')
        ));

        //Practice Excellence additional section
        acf_register_block_type(array(
            'name' => 'content-block',
            'title' => __('Content block'),
            'description' => '',
            'render_template' => 'template-parts/single/content-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('content', 'block'),
            'post_types' => array('page')
        ));

        acf_register_block_type(array(
            'name' => 'representative-transactions',
            'title' => __('Representative Transactions'),
            'description' => '',
            'render_template' => 'template-parts/single/representative-transactions.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('representative', 'transactions'),
            'post_types' => array('page')
        ));

        //Events additional section
        acf_register_block_type(array(
            'name' => 'speakers-block',
            'title' => __('Speakers block'),
            'description' => '',
            'render_template' => 'template-parts/single/speakers-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => false, 'align' => false),
            'keywords' => array('speakers', 'block'),
            'post_types' => array('events')
        ));

        acf_register_block_type(array(
            'name' => 'agenda-block',
            'title' => __('Agenda block'),
            'description' => '',
            'render_template' => 'template-parts/single/agenda-block.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => true, 'align' => false),
            'keywords' => array('agenda', 'block'),
            'post_types' => array('events')
        ));

        acf_register_block_type(array(
            'name' => 'newsletter-signup',
            'title' => __('Newsletter sign up block'),
            'description' => '',
            'render_template' => 'template-parts/blocks/contact/newsletter-signup.php',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'mode' => 'edit',
            'supports' => array('mode' => false, 'multiple' => false, 'align' => false),
            'keywords' => array('newsletter', 'sing', 'up', 'block'),
            'post_types' => array('page')
        ));

    }
}

/**
 * Allow needed Gutenberg blocks
 *
 */
add_filter('allowed_block_types', 'theme_allowed_block_types', 99, 2);
function theme_allowed_block_types($allowed_blocks, $post){
    if ($post->post_type === 'page') {
        switch (basename(get_page_template())) {
            case 'page.php':
                if ($post->ID == get_option('page_on_front')) {
                    $allowed_blocks = array(
                        'core/spacer',
                        'acf/home-main-block',
                        'acf/home-info-block',
                        'acf/home-events-block',
                        'acf/home-about-block',
                        'acf/testimonials-block',
                        'acf/home-news-block',
                        'acf/home-resources-block'
                    );
                } else {
                    $allowed_blocks = array(
                        'core/paragraph',
                        'core/heading',
                        'core/list',
                        'core/freeform',
                        'core/html',
                        'core/image',
                        'core/quote',
                        'core/spacer'
                    );
                }
                break;
            case 'careers.php':
                $allowed_blocks = array(
                    'core/spacer',
                    'acf/info-block',
                    'acf/banner-block',
                    'acf/benefits-block',
                    'acf/contact-block'
                );
                break;
            case 'contact-us.php':
                $allowed_blocks = array(
                    'core/spacer',
                    'acf/info-block',
                    'acf/professionals-block',
                    'acf/contact-info-block'
                );
                break;
            case 'about-us.php':
                $allowed_blocks = array(
                    'core/spacer',
                    'acf/info-block',
                    'acf/media-block',
                    'acf/banner-block',
                    'acf/capabilities-block'
                );
                break;
            case 'management-team.php':
                $allowed_blocks = array(
                    'core/spacer',
                    'core/paragraph',
                    'acf/bio-quote-block',
                    'acf/leadership-team-block'
                );
                break;
            case 'your-life.php':
                $allowed_blocks = array(
                    'core/spacer',
                    'acf/info-block',
                    'acf/testimonials-block',
                    'acf/development-programs',
                    'acf/work-benefits-block',
                    'acf/insurance-retirement',
                    'acf/join-team-block'
                );
                break;
            case 'practice-excellence.php':
                $allowed_blocks = array(
                    'core/paragraph',
                    'core/spacer',
                    'acf/media-block',
                    'acf/bio-quote-block',
                    'acf/leadership-team-block',
                    'acf/content-block',
                    'acf/testimonials-block',
                    'acf/info-block',
                    'acf/representative-transactions'
                );
                break;
            case 'our-insights.php':
                $allowed_blocks = array(
                    'core/spacer',
                    'acf/home-news-block',
                    'acf/home-resources-block',
                    'acf/home-events-block'
                );
                break;
            case 'newsletter-signup.php':
                $allowed_blocks = array(
                    'acf/newsletter-signup'
                );
                break;
        }
    }

    if ($post->post_type === 'jobs') {
        $allowed_blocks = array(
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/freeform',
            'core/html',
            'core/image',
            'core/quote',
            'core/spacer',
            'acf/job-benefits-block'
        );
    }

    if ($post->post_type === 'professionals') {
        $allowed_blocks = array(
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/freeform',
            'core/html',
            'core/image',
            'core/quote',
            'core/spacer',
            'acf/video-block',
            'acf/accordion-block'
        );
    }

    if ($post->post_type === 'resources') {
        $allowed_blocks = array(
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/freeform',
            'core/html',
            'core/image',
            'core/quote',
            'core/spacer',
            'acf/video-block',
            'acf/audio-block',
            'acf/quote-block',
            'acf/slider-block'
        );
    }

    if ($post->post_type === 'events') {
        $allowed_blocks = array(
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/freeform',
            'core/html',
            'core/image',
            'core/spacer',
            'acf/speakers-block',
            'acf/agenda-block'
        );
    }

    if ($post->post_type === 'capability') {
        $allowed_blocks = array(
            'core/heading',
            'core/paragraph',
            'core/list',
            'core/freeform',
            'core/html',
            'core/image',
            'core/quote',
            'core/spacer'
        );
    }

    if ($post->post_type === 'post') {
        $allowed_blocks = array(
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/freeform',
            'core/html',
            'core/image',
            'core/quote',
            'core/spacer',
            'acf/quote-block',
            'acf/slider-block'
        );
    }
    return $allowed_blocks;
}


/**
 * get ACF fields in Gutenberg content for an off-cycle
 */
function get_acf_field_gutenberg($page_id, $acf_field){
    if (function_exists('get_field')) {
        $content = array();
        $post   = get_post($page_id);
        $blocks = parse_blocks($post->post_content);

        // Loop through the blocks
        foreach($blocks as $block){
            //Setup global block post data context
            // before: acf_setup_postdata
            acf_setup_meta( $block['attrs']['data'], $block['attrs']['id'], true );

            // Get ACF fields
            $fields = get_fields();

            $content[] = $fields[$acf_field];
            acf_reset_meta($block['attrs']['id']);
        }

        return $content;
    }
}


/**
 * disable ssl verification for localhost
 */
if (strpos(get_bloginfo('url'), '//localhost') != false) {
    add_filter( 'http_request_args', function ( $r ) {
        $r['sslverify'] = false;
        return $r;
    } );
}

/**
 * Filter found posts by post type - Search page
 */
function get_search_filter() {
    $arr = '';

    if (is_search()) {
        global $wp_query;
        $search_result_type_counts = search_result_type_counts();

        if (count($search_result_type_counts) > 0) {
            $summary_count = 0;
            foreach ($search_result_type_counts as $post_type => $count) {
                if ($post_type == 'post' || $post_type == 'professionals' || $post_type == 'capability' || $post_type == 'events' || $post_type == 'resources') {
                    $summary_count += $count;
                }
            }
            ob_start();
            echo '<ul>';
            $class = (!isset($_GET['type'])) ? 'class="active"' : ''; ?>
            <li <?php echo $class; ?>><a href="<?php echo add_query_arg('s', urlencode(get_search_query()), esc_url(home_url('/'))); ?>">
                <?php echo __('All', 'barley-theme'); ?> (<?php echo $summary_count; ?>)
            </a></li>
            <?php

            foreach ($search_result_type_counts as $post_type => $count):
                switch ($post_type) {
                    case 'professionals':
                        $post_type_label = 'Professionals';
                        break;
                    case 'capability':
                        $post_type_label = 'Capabilities';
                        break;
                    case 'post':
                        $post_type_label = 'News';
                        break;
                    case 'events':
                        $post_type_label = 'Events';
                        break;
                    case 'resources':
                        $post_type_label = 'Resources';
                        break;
                }

                $link = add_query_arg(array(
                    's' => urlencode(get_search_query()),
                    'type' => $post_type,
                ), esc_url(home_url('/')));
                if ($count > 0) :
                    $class = (isset($_GET['type']) && $_GET['type'] === $post_type) ? 'class="active"' : ''; ?>
                    <li <?php echo $class; ?>><a href="<?php echo $link; ?>"><?php echo $post_type_label; ?> (<?php echo $count; ?>)</a></li>
                <?php endif;
            endforeach;
            echo '</ul>';

            $content = ob_get_clean();
            $arr = $content;
        }
    }
    return $arr;
}

function search_result_type_counts(){
    $types = array( 'post' => 0, 'capability' => 0, 'professionals' => 0, 'events' => 0, 'resources' => 0);

    if (function_exists('relevanssi_do_query')) {
        foreach ($types as $type => $val) {
            switch ($type) {
                case 'post':
                    $post_type = 'post';
                    break;
                case 'capability':
                    $post_type = 'capability';
                    break;
                case 'professionals':
                    $post_type = 'professionals';
                    break;
                case 'events':
                    $post_type = 'events';
                    break;
                case 'resources':
                    $post_type = 'resources';
                    break;
            }

            $args = array(
                'post_type' => $post_type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                's' => get_search_query()
            );

            $query = new WP_Query($args);
            $types[$type] = count(relevanssi_do_query($query));
            wp_reset_query();
        }
    }

    return $types;
}