<?php
/**
 * ACF filters and hook
 */

/**
 * ACF functions - default values (if not exist ACF plugin)
 *
 */
if (!class_exists('acf') && !is_admin()) {
    function get_field_reference($field_name, $post_id)
    {
        return '';
    }

    function get_field_objects($post_id = false, $options = array())
    {
        return false;
    }

    function get_fields($post_id = false)
    {
        return false;
    }

    function get_field($field_key, $post_id = false, $format_value = true)
    {
        return false;
    }

    function get_field_object($field_key, $post_id = false, $options = array())
    {
        return false;
    }

    function the_field($field_name, $post_id = false)
    {
    }

    function have_rows($field_name, $post_id = false)
    {
        return false;
    }

    function the_row()
    {
    }

    function reset_rows($hard_reset = false)
    {
    }

    function has_sub_field($field_name, $post_id = false)
    {
        return false;
    }

    function get_sub_field($field_name)
    {
        return false;
    }

    function the_sub_field($field_name)
    {
    }

    function get_sub_field_object($child_name)
    {
        return false;
    }

    function acf_get_child_field_from_parent_field($child_name, $parent)
    {
        return false;
    }

    function register_field_group($array)
    {
    }

    function get_row_layout()
    {
        return false;
    }

    function acf_form_head()
    {
    }

    function acf_form($options = array())
    {
    }

    function update_field($field_key, $value, $post_id = false)
    {
        return false;
    }

    function delete_field($field_name, $post_id)
    {
    }

    function create_field($field)
    {
    }

    function reset_the_repeater_field()
    {
    }

    function the_repeater_field($field_name, $post_id = false)
    {
        return false;
    }

    function the_flexible_field($field_name, $post_id = false)
    {
        return false;
    }

    function acf_filter_post_id($post_id)
    {
        return $post_id;
    }
}

/**
 * Save ACF group to json file
 *
 */
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point($path)
{
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
    // return
    return $path;
}

/**
 * Load ACF group from json file
 *
 */
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point($paths)
{
    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = get_stylesheet_directory() . '/acf-json';
    // return
    return $paths;
}


/**
 * Add ACF options page
 *
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme settings',
        'menu_title' => 'Theme settings',
        'menu_slug' => 'acf-options',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

/**
 * Register a GMAP API key in ACF
 */
add_action('acf/init', 'my_acf_init');
function my_acf_init()
{
    $api_key = get_field('api_key', 'options');
    if (!empty($api_key)) {
        acf_update_setting('google_api_key', $api_key);
    }
}


/**
 * Add custom values for some ACF Select fields
 *
 */
add_filter('acf/load_field/name=form', 'acf_load_form_field_choices');
function acf_load_form_field_choices($field)
{
    $field['choices'] = array();
    $forms = get_posts(array(
        'post_type' => 'wpcf7_contact_form',
        'numberposts' => -1,
        'post_status' => 'publish'
    ));
    if (is_array($forms) && count($forms) > 0) {
        foreach ($forms as $form) {
            $field['choices'][$form->ID] = $form->post_title;
        }
    }
    return $field;
}