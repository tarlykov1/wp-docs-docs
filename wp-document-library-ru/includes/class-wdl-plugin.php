<?php
if (! defined('ABSPATH')) {
    exit;
}

class WDL_Plugin {
    private static $instance;
    public $settings;
    public $helpers;

    public static function get_instance() {
        if (! self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->includes();
        $this->init_components();

        register_activation_hook(WDL_PLUGIN_FILE, array('WDL_Plugin', 'activate'));
        register_deactivation_hook(WDL_PLUGIN_FILE, array('WDL_Plugin', 'deactivate'));

        add_action('plugins_loaded', array($this, 'load_textdomain'));
    }

    private function includes() {
        require_once WDL_PLUGIN_DIR . 'includes/class-wdl-helpers.php';
        require_once WDL_PLUGIN_DIR . 'includes/class-wdl-post-types.php';
        require_once WDL_PLUGIN_DIR . 'includes/class-wdl-taxonomies.php';
        require_once WDL_PLUGIN_DIR . 'includes/class-wdl-meta-boxes.php';
        require_once WDL_PLUGIN_DIR . 'includes/class-wdl-settings.php';
        require_once WDL_PLUGIN_DIR . 'includes/class-wdl-frontend.php';
        require_once WDL_PLUGIN_DIR . 'includes/class-wdl-shortcodes.php';
        require_once WDL_PLUGIN_DIR . 'includes/class-wdl-widget.php';
        require_once WDL_PLUGIN_DIR . 'includes/class-wdl-blocks.php';
        require_once WDL_PLUGIN_DIR . 'includes/class-wdl-admin-pages.php';
    }

    private function init_components() {
        $this->helpers = new WDL_Helpers();
        new WDL_Post_Types();
        new WDL_Taxonomies();
        new WDL_Meta_Boxes();
        $this->settings = new WDL_Settings();
        new WDL_Frontend($this->helpers, $this->settings);
        new WDL_Shortcodes($this->helpers, $this->settings);
        new WDL_Widget($this->helpers, $this->settings);
        new WDL_Blocks($this->helpers, $this->settings);
        new WDL_Admin_Pages();
    }

    public function load_textdomain() {
        load_plugin_textdomain('wp-document-library-ru', false, dirname(plugin_basename(WDL_PLUGIN_FILE)) . '/languages');
    }

    public static function activate() {
        WDL_Post_Types::register_post_type();
        WDL_Taxonomies::register_taxonomy();
        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }
}
