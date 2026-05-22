<?php
/**
 * Plugin Name: WP Document Library RU
 * Description: Библиотека документов для WordPress.
 * Version: 1.0.0
 * Author: Tarlykov
 * Text Domain: wp-document-library-ru
 * Domain Path: /languages
 */

if (! defined('ABSPATH')) {
    exit;
}

define('WDL_PLUGIN_VERSION', '1.0.0');
define('WDL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WDL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WDL_PLUGIN_FILE', __FILE__);

require_once WDL_PLUGIN_DIR . 'includes/class-wdl-plugin.php';

WDL_Plugin::get_instance();
