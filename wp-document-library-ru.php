<?php
/**
 * Plugin Name: Библиотека документов Фонда
 * Plugin URI: https://fondpp.org/
 * Description: Кастомный плагин для публикации, просмотра и скачивания документов Фонда поддержки пострадавших от преступлений.
 * Version: 1.2.0
 * Author: Tarlykov
 * Author URI: https://fondpp.org/
 * Text Domain: fondpp-document-library
 * Domain Path: /languages
 * Update URI: false
 */

if (! defined('ABSPATH')) {
    exit;
}

define('WDL_PLUGIN_VERSION', '1.2.0');
define('WDL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WDL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WDL_PLUGIN_FILE', __FILE__);

require_once WDL_PLUGIN_DIR . 'includes/class-wdl-plugin.php';
require_once WDL_PLUGIN_DIR . 'includes/class-wdl-frontend.php';

WDL_Plugin::get_instance();

if (class_exists('WDL_Frontend')) {
    WDL_Frontend::init();
}

add_filter('template_include', 'wdl_force_document_single_template', PHP_INT_MAX);

function wdl_force_document_single_template($template)
{
    if (is_admin() || ! is_singular()) {
        return $template;
    }

    $post_id = get_queried_object_id();
    if (! $post_id) {
        return $template;
    }

    $post_type = get_post_type($post_id);
    $document_post_types = array('wdl_document');

    $request_uri = isset($_SERVER['REQUEST_URI'])
        ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']))
        : '';
    $is_document_url = strpos($request_uri, '/documents/') !== false;

    if (in_array($post_type, $document_post_types, true) || $is_document_url) {
        $plugin_template = WDL_PLUGIN_DIR . 'templates/single-document.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }

    return $template;
}
