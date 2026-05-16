<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Shortcodes {
    private $helpers; public function __construct($helpers){$this->helpers=$helpers; add_shortcode('document_library',array($this,'render'));}
    public function render($atts){ $a=shortcode_atts(array('view'=>WDL_Settings::get_option('default_view','table'),'category'=>'','limit'=>WDL_Settings::get_option('per_page',10),'show_search'=>WDL_Settings::get_option('show_search',1)?'yes':'no','show_filters'=>WDL_Settings::get_option('show_filters',1)?'yes':'no','show_thumbnails'=>WDL_Settings::get_option('show_thumbnails',1)?'yes':'no','only_pdf'=>'no','important'=>'no','orderby'=>'date','order'=>'DESC'),$atts,'document_library');
        ob_start(); $query_args=['post_type'=>'wdl_document','post_status'=>'publish','posts_per_page'=>absint($a['limit']),'orderby'=>sanitize_key($a['orderby']),'order'=>('ASC'===strtoupper($a['order']))?'ASC':'DESC'];
        if(!empty($a['category'])){$term=get_term_by('slug',sanitize_title($a['category']),'wdl_document_category'); if(!$term){ echo '<div class="wdl-empty">Документы не найдены</div>'; return ob_get_clean(); } $query_args['tax_query']=[['taxonomy'=>'wdl_document_category','field'=>'slug','terms'=>$term->slug]];}
        $q=new WP_Query($query_args); $data=['query'=>$q,'atts'=>$a,'helpers'=>$this->helpers]; include WDL_PLUGIN_DIR.'templates/document-'.$a['view'].'.php'; wp_reset_postdata(); return ob_get_clean(); }
}
