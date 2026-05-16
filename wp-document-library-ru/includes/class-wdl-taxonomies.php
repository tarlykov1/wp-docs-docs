<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Taxonomies {
    public function __construct(){ add_action('init', array(__CLASS__,'register_taxonomy')); }
    public static function register_taxonomy(){
        register_taxonomy('wdl_document_category', array('wdl_document'), array(
            'hierarchical'=>true,'labels'=>array('name'=>'Категории документов','singular_name'=>'Категория документа','menu_name'=>'Категории документов'),
            'show_admin_column'=>true,'show_in_rest'=>true,'rewrite'=>array('slug'=>'document-category')
        ));
    }
}
