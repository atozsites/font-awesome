<?php
/*
Plugin Name: Atozsites Font Awesome Icons
Plugin URI: http://www.atozsites.com
Description: Use the Font Awesome icon set within WordPress.
Version: 1.0
Author: Atozsites
Author URI: https://github.com/atozsites/font-awesome
 */

define('FONTAWESOME_VERSION', '4.7.0');

function atozsites_register_plugin_styles()
{
    global $wp_styles;

    wp_enqueue_style('font-awesome-styles', plugins_url('assets/css/font-awesome.css', __FILE__), array(), FONTAWESOME_VERSION, 'all');
}
add_action('wp_enqueue_scripts', 'atozsites_register_plugin_styles');
add_action('admin_enqueue_scripts', 'atozsites_register_plugin_styles');

function atozsites_setup_shortcode($params)
{
    return '<i class="fa fa-' . esc_attr($params['name']) . '">&nbsp;</i>';
}
add_shortcode('icon', 'atozsites_setup_shortcode');

add_filter('widget_text', 'do_shortcode');

function atozsites_add_tinymce_hooks()
{
    if ((current_user_can('edit_posts') || current_user_can('edit_pages')) && get_user_option('rich_editing')) {
        add_filter('mce_external_plugins', 'atozsites_register_tinymce_plugin');
        add_filter('mce_buttons', 'atozsites_add_tinymce_buttons');
        add_filter('teeny_mce_buttons', 'atozsites_add_tinymce_buttons');
        add_filter('mce_css', 'atozsites_add_tinymce_editor_sytle');
    }
}
add_action('admin_init', 'atozsites_add_tinymce_hooks');

function atozsites_register_tinymce_plugin($plugin_array = array())
{
    $plugin_array['font_awesome_glyphs'] = plugins_url('assets/js/font-awesome.js', __FILE__);

    return $plugin_array;
}

function atozsites_add_tinymce_buttons($buttons = array())
{
    $buttons = (array) $buttons;
    array_push($buttons, '|', 'font_awesome_glyphs');

    return $buttons;
}

function atozsites_add_tinymce_editor_sytle($mce_css)
{
    $mce_css .= ', ' . plugins_url('assets/css/font-awesome.min.css', __FILE__);

    return $mce_css;
}
