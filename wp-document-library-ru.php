<?php
/**
 * Plugin Name: Библиотека документов Фонда
 * Plugin URI: https://fondpp.org/
 * Description: Кастомный плагин для публикации, просмотра и скачивания документов Фонда поддержки пострадавших от преступлений.
 * Version: 1.1.0
 * Author: Tarlykov
 * Author URI: https://fondpp.org/
 * Text Domain: fondpp-document-library
 * Domain Path: /languages
 * Update URI: false
 */

if (! defined('ABSPATH')) {
    exit;
}

define('WDL_PLUGIN_VERSION', '1.1.0');
define('WDL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WDL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WDL_PLUGIN_FILE', __FILE__);

require_once WDL_PLUGIN_DIR . 'includes/class-wdl-plugin.php';
require_once WDL_PLUGIN_DIR . 'includes/class-wdl-frontend.php';

WDL_Plugin::get_instance();

if (class_exists('WDL_Frontend')) {
    WDL_Frontend::init();
}

add_action('wp_footer', function () {
    echo "\n<!-- FONDPP ACTIVE PLUGIN REALLY LOADED 1.0.8 -->\n";
}, 9999);

add_action('template_redirect', function () {
    if (! current_user_can('manage_options')) {
        return;
    }

    if (! isset($_GET['fondpp_force_template'])) {
        return;
    }

    get_header();

    echo '<main style="padding:40px;max-width:900px;margin:0 auto;">';
    echo '<h1>FONDPP FORCE TEMPLATE WORKS</h1>';
    echo '<p>Если этот текст виден, активный плагин может перехватить фронт.</p>';
    echo '<p>Post ID: ' . esc_html((string) get_queried_object_id()) . '</p>';
    echo '<p>Post type: ' . esc_html((string) get_post_type(get_queried_object_id())) . '</p>';
    echo '</main>';

    get_footer();
    exit;
}, 0);

add_filter('template_include', function ($template) {
    $request_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';

    if (strpos($request_uri, '/documents/bezopasnoe-dolgoletie/') !== false) {
        $plugin_template = plugin_dir_path(__FILE__) . 'templates/single-document.php';

        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }

    return $template;
}, 9999);
