<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Frontend {
    private $helpers; private $settings;
    public function __construct($helpers,$settings){$this->helpers=$helpers;$this->settings=$settings; add_action('wp_enqueue_scripts',array($this,'assets')); add_filter('template_include',array($this,'single_template'),99); add_filter('the_content',array($this,'single_content_fallback'),20); if (defined('WP_DEBUG') && WP_DEBUG) { add_action('wp_footer',array($this,'debug_post_type_comment')); } }
    public function assets(){ wp_enqueue_style('wdl-frontend',WDL_PLUGIN_URL.'assets/css/frontend.css',array(),WDL_PLUGIN_VERSION); wp_enqueue_script('wdl-frontend',WDL_PLUGIN_URL.'assets/js/frontend.js',array('jquery'),WDL_PLUGIN_VERSION,true); }
    public function single_template($template){
        if (! is_singular() || ! WDL_Settings::get_option('enable_single',1)) {
            return $template;
        }

        $post_type = get_post_type();
        if (defined('WP_DEBUG') && WP_DEBUG) { error_log('FONDPP template_include post_type: ' . (string) $post_type); }

        if (! $this->is_document_post_type($post_type)) {
            return $template;
        }

        $plugin_template = WDL_PLUGIN_DIR . 'templates/single-document.php';
        if (defined('WP_DEBUG') && WP_DEBUG) { error_log('FONDPP plugin template path: ' . $plugin_template); }
        if (file_exists($plugin_template)) {
            if (defined('WP_DEBUG') && WP_DEBUG) { error_log('FONDPP single document template loaded'); }
            return $plugin_template;
        }

        if (defined('WP_DEBUG') && WP_DEBUG) { error_log('FONDPP single document template not found'); }

        return $template;
    }

    public function single_content_fallback($content){
        if (! is_singular() || ! in_the_loop() || ! is_main_query()) {
            return $content;
        }

        $post_type = get_post_type();
        if (! $this->is_document_post_type($post_type)) {
            return $content;
        }

        $partial = WDL_PLUGIN_DIR . 'templates/parts/single-document-content.php';
        if (! file_exists($partial)) {
            return $content;
        }

        ob_start();
        include $partial;
        return (string) ob_get_clean();
    }

    private function is_document_post_type($post_type){
        return in_array((string) $post_type, array('wdl_document'), true);
    }

    public function debug_post_type_comment(){
        if (! is_singular() || ! defined('WP_DEBUG') || ! WP_DEBUG) {
            return;
        }

        echo "\n<!-- FONDPP DEBUG post_type: " . esc_html((string) get_post_type()) . " -->\n";
    }
}
