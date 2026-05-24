<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Frontend {
    private static $bootstrapped = false;
    private $helpers; private $settings;
    public function __construct($helpers,$settings){$this->helpers=$helpers;$this->settings=$settings; add_action('wp_enqueue_scripts',array($this,'assets'));  add_filter('template_include',array($this,'single_template'),99); add_filter('template_include',array($this,'taxonomy_template'),98); add_filter('the_content',array($this,'single_content_fallback'),20); add_action('template_redirect',array($this,'disable_generatepress_single_bits')); add_filter('generate_show_entry_header',array($this,'hide_generatepress_entry_header')); add_filter('generate_show_title',array($this,'hide_generatepress_title')); add_filter('generate_show_post_image',array($this,'hide_generatepress_featured_image')); add_filter('generate_featured_image_output',array($this,'hide_generatepress_featured_image_output')); }
    public function assets(){ wp_enqueue_style('wdl-frontend',WDL_PLUGIN_URL.'assets/css/frontend.css',array(),WDL_PLUGIN_VERSION); wp_enqueue_script('wdl-frontend',WDL_PLUGIN_URL.'assets/js/frontend.js',array('jquery'),WDL_PLUGIN_VERSION,true); }

    public function single_template($template){
        if (! is_singular() || ! WDL_Settings::get_option('enable_single',1)) {
            return $template;
        }

        $post_type = get_post_type();
        if (defined('WP_DEBUG') && WP_DEBUG) { error_log('FONDPP template_include post_type: ' . (string) $post_type); }

        if (! $this->is_document_single_context()) {
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


    public function taxonomy_template($template){
        if (! is_tax('wdl_document_category')) {
            return $template;
        }

        $plugin_template = WDL_PLUGIN_DIR . 'templates/taxonomy-document-category.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }

        return $template;
    }

    public function single_content_fallback($content){
        if (! is_singular() || ! in_the_loop() || ! is_main_query() || ! WDL_Settings::get_option('enable_single',1)) {
            return $content;
        }

        $post_type = get_post_type();
        if (! $this->is_document_single_context()) {
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

    public function disable_generatepress_single_bits(){
        if (! $this->is_document_single()) {
            return;
        }

        remove_action('generate_after_entry_header', 'generate_post_image', 10);
    }

    public function hide_generatepress_entry_header($show){
        return $this->is_document_single() ? false : $show;
    }

    public function hide_generatepress_title($show){
        return $this->is_document_single() ? false : $show;
    }

    public function hide_generatepress_featured_image($show){
        return $this->is_document_single() ? false : $show;
    }

    public function hide_generatepress_featured_image_output($output){
        return $this->is_document_single() ? '' : $output;
    }

    private function is_document_single(){
        return is_singular() && $this->is_document_single_context();
    }

    private function is_document_post_type($post_type){
        return in_array((string) $post_type, array('wdl_document'), true);
    }

    private function is_document_single_context(){
        if (! is_singular()) {
            return false;
        }

        $post_id = get_queried_object_id();
        if (! $post_id) {
            return false;
        }

        if ($this->is_document_post_type(get_post_type($post_id))) {
            return true;
        }
        return false;
    }
    public static function init(){
        if (self::$bootstrapped) {
            return;
        }

        self::$bootstrapped = true;

        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style('wdl-frontend', WDL_PLUGIN_URL . 'assets/css/frontend.css', array(), WDL_PLUGIN_VERSION);
            wp_enqueue_script('wdl-frontend', WDL_PLUGIN_URL . 'assets/js/frontend.js', array('jquery'), WDL_PLUGIN_VERSION, true);
        });
    }
}
