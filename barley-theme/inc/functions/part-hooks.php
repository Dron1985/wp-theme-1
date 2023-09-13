<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package barley-theme
 */

/**
 * Hide Posts and Comments from Admin panel
 *
 */
add_action('admin_menu', 'remove_menu');
function remove_menu(){
    remove_menu_page('edit-comments.php');
}

/**
 * remove icon comments in admin bar
 */
function my_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'my_admin_bar_render' );

/**
 * Disable wp-emoji script
 *
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Disable wp-embed script
 *
 */
add_action('init', function () {
    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');

    // Turn off oEmbed auto discovery.
    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
}, PHP_INT_MAX - 1);

/**
 * Disable json api
 *
 */
add_action('after_setup_theme', 'remove_json_api');
function remove_json_api(){
    // Remove the REST API lines from the HTML Header
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');

    // Turn off oEmbed auto discovery.
    add_filter('embed_oembed_discover', '__return_false');

    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');

    // Remove all embeds rewrite rules.
    //add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
}

/**
 * Disable wlwmanifest_link in HEAD
 *
 */
remove_action('wp_head', 'wlwmanifest_link');

/**
 * Remove wordpress version in HEAD
 *
 */
function remove_version_info(){
    return '';
}

add_filter('the_generator', 'remove_version_info');

/**
 * Remove post shortlink in HEAD
 *
 */
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * Remove links to the extra feeds such as category feeds
 *
 */
remove_action('wp_head', 'feed_links_extra', 3);

/**
 * Remove feeds: Post and Comment Feed
 *
 */
remove_action('wp_head', 'feed_links', 2);

/**
 * Remove rsd link from HEAD
 *
 */
remove_action('wp_head', 'rsd_link');

/**
 * Disable DNS pre-fetch
 *
 */
remove_action('wp_head', 'wp_resource_hints', 2);

/**
 * Hide admin bar
 *
 */
add_filter('show_admin_bar', '__return_false');

/**
 * Custom image size
 */
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'full-hd', 1920, 960 );
    add_image_size( 'big-img', 1360, 820 );
}

/**
 * Allow SVG through WordPress Media Uploader
 *
 */
add_filter('upload_mimes', 'cc_mime_types');
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
    global $wp_version;
    if ($wp_version == '4.7' || ((float)$wp_version < 4.7)) {
        return $data;
    }
    $filetype = wp_check_filetype($filename, $mimes);
    return ['ext' => $filetype['ext'], 'type' => $filetype['type'], 'proper_filename' => $data['proper_filename']];
}, 10, 4);
function cc_mime_types($mimes){
    $mimes['vcf'] = 'text/x-vcard';
    $mimes['svg'] = 'image/svg+xml';
    $mimes['json'] = 'application/json';
    return $mimes;
}

/**
 * Limit excerpt length
 *
 */
add_filter('excerpt_length', 'custom_excerpt_length', 999);
function custom_excerpt_length($length){
    return 30;
}

/**
 * Change symbols after excerpt
 *
 */
add_filter('excerpt_more', 'custom_excerpt_more');
function custom_excerpt_more($more){
    return '...';
}

/**
 * Disable wpautop for excerpt
 *
 */
remove_filter('the_excerpt', 'wpautop');

/**
 * WP init start session
 */
function sess_start() {
    if (!session_id())
        session_start();
}
add_action('init','sess_start');

/**
 * WP header hook - add custom scripts
 */
function hook_header() {

    if (is_singular('professionals')) {
        $_SESSION['filter_id'] = get_the_ID();
    }

    if (is_home()){
        $_SESSION['filter_id'] = '';
    }

    if (is_singular('post') || is_singular('resources')) : ?>
        <!--Generic Social Share -->
        <script type="text/javascript">
            function genericSocialShare(url) {
                window.open(url,'sharer','toolbar=0,status=0,width=648,height=395');
                return true;
            }
        </script>
    <?php endif;
}
add_action('wp_head','hook_header');


/**
 * Default redirects
 */
add_action('template_redirect', 'wp_redirect_post');
function wp_redirect_post(){
    if ( is_attachment() ) {
        global $post;
        if ( $post && $post->post_parent ) {
            wp_redirect( esc_url( get_permalink( $post->post_parent ) ), 301 );
            exit;
        } else {
            wp_redirect( esc_url( home_url( '/' ) ), 301 );
            exit;
        }
    }

    if ( is_tax('job-position') || is_tax('capability-category') || is_tax('content-type') ||
        is_tax('category-school') || is_tax('category-college')) {
        switch (true) {
            case is_tax('job-position'):
                $page_link = get_post_type_archive_link('jobs');
                break;
            case is_tax('capability-category'):
                $page_link = get_post_type_archive_link('capability');
                break;
            case is_tax('content-type'):
                $page_link = get_post_type_archive_link('resources');
                break;
            case is_tax('category-school'):
                $page_link = get_post_type_archive_link('professionals');
                break;
            case is_tax('category-college'):
                $page_link = get_post_type_archive_link('professionals');
                break;
            case is_category():
                $page_news = get_option('page_for_posts');
                $page_link = get_the_permalink($page_news);
                break;
        }

        $link = (!empty($page_link)) ? $page_link : esc_url(home_url('/'));
        wp_redirect( $link, '301' );
        exit();
    }

    if ( is_date() || is_author() || is_tag()) {
        wp_redirect(esc_url(home_url('/')), '301' );
        exit();
    }
}


/**
 * Add in our new custom query vars first
 */
add_filter('query_vars', 'add_query_vars_filter');
function add_query_vars_filter($vars){
    $vars[] = "location";
    $vars[] = "position";
    $vars[] = "color";
    $vars[] = "content-type";
    $vars[] = "topic";
    $vars[] = "attorney";
    $vars[] = "college";
    $vars[] = "law-school";
    $vars[] = "practice-area";
    $vars[] = "type";

    return $vars;
}

/**
 * Global query settings
 */
add_action('pre_get_posts', 'archive_query', 10, 1);
function archive_query($query){
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_home() && !is_admin()) {
            $query->set('post_type', 'post');
            $query->set('post_status', 'publish');
            $query->set('order', 'DESC');
            $query->set('posts_per_page', 12);

            if (!empty(get_query_var('attorney'))) {
                $attorney = get_page_by_slug(get_query_var('attorney'), OBJECT, 'professionals');
                $query->set('meta_query', array(
                    array('key'     => 'news_author_list',
                          'value'   => $attorney->ID,
                          'compare' => 'LIKE')
                ));
            }

            if (!empty(get_query_var('topic'))) {
                $topic = get_page_by_slug(get_query_var('topic'), OBJECT, 'capability');
                $query->set('meta_query', array(
                    array('key'     => 'news_topics',
                          'value'   => $topic->ID,
                          'compare' => 'LIKE')
                ));
            }

            if (!empty(get_query_var('content-type'))) {
                $term = get_query_var('content-type');
                $query->set('tax_query', array(
                    array(
                        'taxonomy' => 'category',
                        'field'    => 'slug',
                        'terms'    => $term
                    )
                ));
            }
        }

        if (is_post_type_archive('jobs') && !is_admin()) {
            $query->set('post_type', 'jobs');
            $query->set('post_status', 'publish');
            $query->set('order', 'DESC');
            $query->set('posts_per_page', 5);
        }

        if (is_post_type_archive('resources') && !is_admin()) {
            $query->set('post_type', 'resources');
            $query->set('post_status', 'publish');
            $query->set('order', 'DESC');
            $query->set('posts_per_page', 9);

            if (!empty(get_query_var('topic'))) {
                $topic = get_page_by_slug(get_query_var('topic'), OBJECT, 'capability');
                $query->set('meta_query', array(
                    array('key'     => 'resource_main_info_topics',
                          'value'   => $topic->ID,
                          'compare' => 'LIKE')
                ));
            }

            if (!empty(get_query_var('attorney'))) {
                $attorney = get_page_by_slug(get_query_var('attorney'), OBJECT, 'professionals');
                $query->set('meta_query', array(
                    array('key'     => 'resource_sidebar_professionals',
                        'value'   => $attorney->ID,
                        'compare' => 'LIKE')
                ));
            }
        }

        if (is_post_type_archive('events') && !is_admin()) {
            $query->set('post_type', 'events');
            $query->set('post_status', 'publish');
            $query->set('order', 'DESC');
            $query->set('posts_per_page', 9);
        }

        if (is_post_type_archive('professionals') && !is_admin()) {
            $query->set('post_type', 'professionals');
            $query->set('post_status', 'publish');
            $query->set('meta_key', 'prof_main_info_last_name');
            $query->set('orderby', 'meta_value');
            $query->set('order', 'ASC');
            $query->set('posts_per_page', 12);

            $query->set('meta_query', array(
                array('key'     => 'hide_on_listing',
                      'value'   => true,
                      'compare' => '!='
                )
            ));
        }

        if (is_search() ) {
            if (!empty(get_query_var('type'))) {
                $query->set('post_type', get_query_var('type'));
            } else {
                $query->set('post_type', array('post', 'events', 'resources', 'capability', 'professionals'));
            }

            $query->set('posts_per_page', 5);
            $query->set('order', 'DESC');
            $query->set('orderby', 'date');
            $query->set('paged', $paged);
        }

    }

    return $query;
}

/**
 * Add custom body class
 */
function new_body_class($classes) {

    if (is_front_page()) {
        $classes[] = 'home-page';
    } elseif (is_404()) {
        $classes[] = 'error404';
    }

    return $classes;
}
add_filter('body_class', 'new_body_class');

/**
 * Limit revision
 */
add_filter( 'wp_revisions_to_keep', 'limit_revisions' );
function limit_revisions( $revisions ) {
    return 5;
}

/**
 * Contact form replace default text '---'
 */
function my_wpcf7_form_elements($html) {
    $text = 'Select Salutation';
    $html = str_replace('---',  $text, $html);
    return $html;
}
add_filter('wpcf7_form_elements', 'my_wpcf7_form_elements');



/**
 * Create "virtual page" for download pdf brochure
 *
 */
//Add a wp query variable to redirect to
add_action('query_vars', 'set_query_var_download');
function set_query_var_download($vars)
{
    array_push($vars, 'download_pdf'); // ref url redirected to in add rewrite rule
    return $vars;
}

//Create a redirect
add_action('init', 'custom_2_add_rewrite_rule');
function custom_2_add_rewrite_rule()
{
    add_rewrite_rule('^download-brochure', 'index.php?download_pdf=1', 'top');
    flush_rewrite_rules();
}

//Return the file we want...
add_filter('template_include', 'include_custom_template');
function include_custom_template($template)
{
    if (get_query_var('download_pdf')) {
        $template = get_template_directory() . "/templates/download-pdf.php";
    }
    return $template;
}

/**
 * replace post_type name in url
 */
function na_remove_slug( $post_link, $post, $leavename ) {
    if ( 'professionals' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }
    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;
}
add_filter( 'post_type_link', 'na_remove_slug', 10, 3 );

/**
 * change request for pre_get_posts
 */
function na_parse_request( $query ) {
    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }

    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'professionals', 'page' ) );
    }
}
add_action( 'pre_get_posts', 'na_parse_request' );