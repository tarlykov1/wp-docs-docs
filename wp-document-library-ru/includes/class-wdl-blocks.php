<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Blocks {
    public function __construct(){ add_action('init',array($this,'register')); }
    public function register(){ wp_register_script('wdl-block',WDL_PLUGIN_URL.'assets/js/block.js',array('wp-blocks','wp-element','wp-editor'),WDL_PLUGIN_VERSION,true); register_block_type('wdl/document-library',array('editor_script'=>'wdl-block','render_callback'=>array($this,'render'),'attributes'=>array('view'=>array('type'=>'string','default'=>'table'),'limit'=>array('type'=>'number','default'=>10),'category'=>array('type'=>'string','default'=>'')))); }
    public function render($atts){ return do_shortcode('[document_library view="'.esc_attr($atts['view']??'table').'" limit="'.absint($atts['limit']??10).'" category="'.esc_attr($atts['category']??'').'"]'); }
}
