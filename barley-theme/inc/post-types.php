<?php
add_action('init', 'barley_theme_post_types_init');
function barley_theme_post_types_init(){
    //Post type Jobs
    $labels = array(
        'name' => __('Jobs', 'barley-theme'),
        'singular_name' => __('Our Job', 'barley-theme'),
        'add_new' => __('Add New Job', 'barley-theme'),
        'add_new_item' => __('Add New Job', 'barley-theme'),
        'edit_item' => __('Edit Job', 'barley-theme'),
        'new_item' => __('New Job', 'barley-theme'),
        'all_items' => __('All Jobs', 'barley-theme'),
        'view_item' => __('View Job', 'barley-theme'),
        'search_items' => __('Search Jobs', 'barley-theme'),
        'not_found' => __('No job found', 'barley-theme'),
        'not_found_in_trash' => __('No job found in Trash', 'barley-theme'),
        'parent_item_colon' => '',
        'menu_name' => __('Jobs', 'barley-theme')
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => false,
        'capability_type' => 'page',
        'rewrite' => true,
        'has_archive' => 'career-opportunities',
        'hierarchical' => false,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-index-card',
        'supports' => array('title', 'editor'),
        'show_in_rest' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true
    );
    register_post_type('jobs', $args);

    //Post type Locations
    $labels = array(
        'name' => __('Locations', 'barley-theme'),
        'singular_name' => __('Location', 'barley-theme'),
        'add_new' => __('Add New Location', 'barley-theme'),
        'add_new_item' => __('Add New Location', 'barley-theme'),
        'edit_item' => __('Edit Location', 'barley-theme'),
        'new_item' => __('New Location', 'barley-theme'),
        'all_items' => __('All Locations', 'barley-theme'),
        'view_item' => __('View Location', 'barley-theme'),
        'search_items' => __('Search Locations', 'barley-theme'),
        'not_found' => __('No location found', 'barley-theme'),
        'not_found_in_trash' => __('No location found in Trash', 'barley-theme'),
        'parent_item_colon' => '',
        'menu_name' => __('Locations', 'barley-theme')
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => false,
        'capability_type' => 'page',
        'rewrite' => true,
        'has_archive' => 'locations',
        'hierarchical' => false,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-location-alt',
        'supports' => array('title', 'thumbnail'),
        'show_in_rest' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true
    );
    register_post_type('locations', $args);

    //Post type Professionals
    $labels = array(
        'name' => __('Professionals', 'barley-theme'),
        'singular_name' => __('Professional', 'barley-theme'),
        'add_new' => __('Add New employee', 'barley-theme'),
        'add_new_item' => __('Add New employee', 'barley-theme'),
        'edit_item' => __('Edit employee', 'barley-theme'),
        'new_item' => __('New employee', 'barley-theme'),
        'all_items' => __('All employees', 'barley-theme'),
        'view_item' => __('View employee', 'barley-theme'),
        'search_items' => __('Search employees', 'barley-theme'),
        'not_found' => __('No employee found', 'barley-theme'),
        'not_found_in_trash' => __('No employee found in Trash', 'barley-theme'),
        'parent_item_colon' => '',
        'menu_name' => __('Professionals', 'barley-theme')
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => false,
        'capability_type' => 'page',
        'rewrite' => array( 'slug' => false, 'with_front' => false ),
        'has_archive' => 'professionals',
        'hierarchical' => false,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true
    );
    register_post_type('professionals', $args);

    //Post type Capabilities
    $labels = array(
        'name' => __('Capabilities', 'barley-theme'),
        'singular_name' => __('Capability', 'barley-theme'),
        'add_new' => __('Add New Capability', 'barley-theme'),
        'add_new_item' => __('Add New Capability', 'barley-theme'),
        'edit_item' => __('Edit Capability', 'barley-theme'),
        'new_item' => __('New Capability', 'barley-theme'),
        'all_items' => __('All Capability', 'barley-theme'),
        'view_item' => __('View Capability', 'barley-theme'),
        'search_items' => __('Search Capabilities', 'barley-theme'),
        'not_found' => __('No capability found', 'barley-theme'),
        'not_found_in_trash' => __('No capability found in Trash', 'barley-theme'),
        'parent_item_colon' => '',
        'menu_name' => __('Capabilities', 'barley-theme')
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'page',
        'rewrite' => array( 'slug' => 'capability', 'with_front' => false ),
        'has_archive' => 'capabilities',
        'hierarchical' => true,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-open-folder',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'show_in_rest' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true
    );
    register_post_type('capability', $args);

    //Post type Resources
    $labels = array(
        'name' => __('Resources', 'barley-theme'),
        'singular_name' => __('Resource', 'barley-theme'),
        'add_new' => __('Add New Resource', 'barley-theme'),
        'add_new_item' => __('Add New Resource', 'barley-theme'),
        'edit_item' => __('Edit Resource', 'barley-theme'),
        'new_item' => __('New Resource', 'barley-theme'),
        'all_items' => __('All Resources', 'barley-theme'),
        'view_item' => __('View Resource', 'barley-theme'),
        'search_items' => __('Search Resources', 'barley-theme'),
        'not_found' => __('No resource found', 'barley-theme'),
        'not_found_in_trash' => __('No resource found in Trash', 'barley-theme'),
        'parent_item_colon' => '',
        'menu_name' => __('Resources', 'barley-theme')
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => false,
        'capability_type' => 'page',
        'rewrite' => true,
        'has_archive' => 'resources',
        'hierarchical' => false,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-open-folder',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true
    );
    register_post_type('resources', $args);


    //Post type Events
    $labels = array(
        'name' => __('Events', 'barley-theme'),
        'singular_name' => __('Event', 'barley-theme'),
        'add_new' => __('Add New Event', 'barley-theme'),
        'add_new_item' => __('Add New Event', 'barley-theme'),
        'edit_item' => __('Edit Event', 'barley-theme'),
        'new_item' => __('New Event', 'barley-theme'),
        'all_items' => __('All Events', 'barley-theme'),
        'view_item' => __('View Event', 'barley-theme'),
        'search_items' => __('Search Events', 'barley-theme'),
        'not_found' => __('No event found', 'barley-theme'),
        'not_found_in_trash' => __('No event found in Trash', 'barley-theme'),
        'parent_item_colon' => '',
        'menu_name' => __('Events', 'barley-theme')
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => false,
        'capability_type' => 'page',
        'rewrite' => true,
        'has_archive' => 'events',
        'hierarchical' => false,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true
    );
    register_post_type('events', $args);
}