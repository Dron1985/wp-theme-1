<?php
/**
 * barley-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package barley-theme
 */

if (!function_exists('barley_theme_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function barley_theme_setup()
    {
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'barley-theme'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        ));
    }
endif;
add_action('after_setup_theme', 'barley_theme_setup');

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/uri.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/ajax.php';
require get_template_directory() . '/inc/classes/class.php';

/**
 * Include post types
 */
require get_template_directory() . '/inc/post-types.php';

/**
 * Include taxonomies
 */
require get_template_directory() . '/inc/taxonomies.php';

/**
 * Extra functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/functions/part-acf.php';
require get_template_directory() . '/inc/functions/part-hooks.php';
require get_template_directory() . '/vendor/autoload.php';