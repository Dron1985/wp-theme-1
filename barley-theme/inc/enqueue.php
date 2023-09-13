<?php
/**
 * Enqueue scripts and styles.
 */

add_action('wp_enqueue_scripts', 'barley_theme_enqueue_styles');
function barley_theme_enqueue_styles(){
    wp_enqueue_style('barley_theme-global-style', barley_theme_get_css_uri('style'));
}

add_action('wp_enqueue_scripts', 'barley_theme_enqueue_scripts', 0);
function barley_theme_enqueue_scripts(){
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri().'/inc/js/jquery.min.js', array(), '3.2.1', true);
    wp_enqueue_script('jquery');

    //wp_enqueue_script('polyfill-script', 'https://cdnjs.cloudflare.com/ajax/libs/js-polyfills/0.1.42/polyfill.min.js', array(), '20210901', true);

    wp_enqueue_script('global', barley_theme_get_js_uri('global'), array(), '20210901', true);
    wp_localize_script( 'global', 'ajaxvars', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

    if (is_singular('locations') || is_post_type_archive('jobs') || is_post_type_archive('resources') ||
        is_post_type_archive('events') || is_post_type_archive('professionals') || is_home()) {
        switch (true) {
            case is_singular('locations') :
                $base_url = get_the_permalink();
                break;
            case is_post_type_archive('jobs'):
                $base_url = get_post_type_archive_link('jobs');
                break;
            case is_post_type_archive('resources'):
                $base_url = get_post_type_archive_link('resources');
                break;
            case is_post_type_archive('events'):
                $base_url = get_post_type_archive_link('events');
                break;
            case is_post_type_archive('professionals'):
                $base_url = get_post_type_archive_link('professionals');
                break;
            case is_home():
                $page_id  = get_option('page_for_posts');
                $base_url = get_the_permalink($page_id);
                break;
            default:
                $base_url = home_url('/');
        }

        wp_localize_script('global', 'params', array(
            'base_url' => $base_url
        ));

        wp_enqueue_script('filters-script', get_template_directory_uri().'/inc/js/filters.js', array(), '2020602', true);
    }
}
