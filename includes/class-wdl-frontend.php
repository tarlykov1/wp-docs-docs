<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Frontend {
    private $helpers; private $settings;
    public function __construct($helpers,$settings){$this->helpers=$helpers;$this->settings=$settings; add_action('wp_enqueue_scripts',array($this,'assets')); add_filter('template_include',array($this,'single_template')); }
    public function assets(){ wp_enqueue_style('wdl-frontend',WDL_PLUGIN_URL.'assets/css/frontend.css',array(),WDL_PLUGIN_VERSION); wp_enqueue_script('wdl-frontend',WDL_PLUGIN_URL.'assets/js/frontend.js',array('jquery'),WDL_PLUGIN_VERSION,true); }
    public function single_template($template){ if (is_singular('wdl_document') && WDL_Settings::get_option('enable_single',1)) return WDL_PLUGIN_DIR.'templates/single-document.php'; return $template; }
}
