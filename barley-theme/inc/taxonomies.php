<?php
add_action('init', 'barley_theme_taxonomies_init', 0);
function barley_theme_taxonomies_init() {
    //Taxonomy positions for posttype Jobs
    $labels = array(
        'name' => __('Positions', 'barley-theme'),
        'singular_name' => __('Positions', 'barley-theme'),
        'search_items' => __('Search Positions', 'barley-theme'),
        'all_items' => __('All Positions', 'barley-theme'),
        'parent_item' => __('Parent Position', 'barley-theme'),
        'parent_item_colon' => __('Parent Position:', 'barley-theme'),
        'edit_item' => __('Edit Position', 'barley-theme'),
        'update_item' => __('Update Position', 'barley-theme'),
        'add_new_item' => __('Add New Position', 'barley-theme'),
        'new_item_name' => __('New Position Name', 'barley-theme'),
        'menu_name' => __('Positions', 'barley-theme')
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'query_var' => false,
        'rewrite' => true,
        'show_in_rest' => true
    );
    register_taxonomy('job-position', array('jobs'), $args);

    //Taxonomy categories for posttype Capability
    $labels = array(
        'name' => __('Capability Categories', 'barley-theme'),
        'singular_name' => __('Category', 'barley-theme'),
        'search_items' => __('Search Categories', 'barley-theme'),
        'all_items' => __('All Categories', 'barley-theme'),
        'parent_item' => __('Parent Category', 'barley-theme'),
        'parent_item_colon' => __('Parent Category:', 'barley-theme'),
        'edit_item' => __('Edit Category', 'barley-theme'),
        'update_item' => __('Update Category', 'barley-theme'),
        'add_new_item' => __('Add New Category', 'barley-theme'),
        'new_item_name' => __('New Category Name', 'barley-theme'),
        'menu_name' => __('Categories', 'barley-theme')
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'query_var' => false,
        'rewrite' => true,
        'show_in_rest' => true
    );
    register_taxonomy('capability-category', array('capability'), $args);

    //Taxonomy content type for posttype Resources
    $labels = array(
        'name' => __('Content Types', 'barley-theme'),
        'singular_name' => __('Content Type', 'barley-theme'),
        'search_items' => __('Search Content Types', 'barley-theme'),
        'all_items' => __('All Content Types', 'barley-theme'),
        'parent_item' => __('Parent Content Type', 'barley-theme'),
        'parent_item_colon' => __('Parent Content Type:', 'barley-theme'),
        'edit_item' => __('Edit Content Type', 'barley-theme'),
        'update_item' => __('Update Content Type', 'barley-theme'),
        'add_new_item' => __('Add New Content Type', 'barley-theme'),
        'new_item_name' => __('New Content Type Name', 'barley-theme'),
        'menu_name' => __('Content Types', 'barley-theme')
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'query_var' => false,
        'rewrite' => true,
        'show_in_rest' => true
    );
    register_taxonomy('content-type', array('resources'), $args);

    //Taxonomy Law Schools for posttype professionals
    $labels = array(
        'name' => __('Law Schools', 'barley-theme'),
        'singular_name' => __('Law School', 'barley-theme'),
        'search_items' => __('Search Schools', 'barley-theme'),
        'all_items' => __('All Schools', 'barley-theme'),
        'parent_item' => __('Parent School', 'barley-theme'),
        'parent_item_colon' => __('Parent School:', 'barley-theme'),
        'edit_item' => __('Edit School', 'barley-theme'),
        'update_item' => __('Update School', 'barley-theme'),
        'add_new_item' => __('Add New School', 'barley-theme'),
        'new_item_name' => __('New School Name', 'barley-theme'),
        'menu_name' => __('Law Schools', 'barley-theme')
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'query_var' => false,
        'rewrite' => true,
        'show_in_rest' => true
    );
    register_taxonomy('category-school', array('professionals'), $args);

    //Taxonomy Colleges for posttype professionals
    $labels = array(
        'name' => __('Colleges', 'barley-theme'),
        'singular_name' => __('Colleges', 'barley-theme'),
        'search_items' => __('Search Colleges', 'barley-theme'),
        'all_items' => __('All Colleges', 'barley-theme'),
        'parent_item' => __('Parent College', 'barley-theme'),
        'parent_item_colon' => __('Parent College:', 'barley-theme'),
        'edit_item' => __('Edit College', 'barley-theme'),
        'update_item' => __('Update College', 'barley-theme'),
        'add_new_item' => __('Add New College', 'barley-theme'),
        'new_item_name' => __('New College Name', 'barley-theme'),
        'menu_name' => __('Colleges', 'barley-theme')
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'query_var' => false,
        'rewrite' => true,
        'show_in_rest' => true
    );
    register_taxonomy('category-college', array('professionals'), $args);


}