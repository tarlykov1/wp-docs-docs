<?php
/**
 * Plugin Name: Библиотека документов Фонда
 * Plugin URI: https://fondpp.org/
 * Description: Кастомный плагин для публикации, просмотра и скачивания документов Фонда поддержки пострадавших от преступлений.
 * Version: 1.0.7
 * Author: Tarlykov
 * Author URI: https://fondpp.org/
 * Text Domain: fondpp-document-library
 * Domain Path: /languages
 * Update URI: false
 */

if (! defined('ABSPATH')) {
    exit;
}

define('WDL_PLUGIN_VERSION', '1.0.7');
define('WDL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WDL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WDL_PLUGIN_FILE', __FILE__);

require_once WDL_PLUGIN_DIR . 'includes/class-wdl-plugin.php';

WDL_Plugin::get_instance();

add_action('wp_footer', function () {
    echo "\n<!-- FONDPP ACTIVE PLUGIN LOADED VERSION 1.0.7 -->\n";
}, 9999);
