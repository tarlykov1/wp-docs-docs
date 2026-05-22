<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Post_Types {
    public function __construct(){ add_action('init', array(__CLASS__,'register_post_type')); }
    public static function register_post_type(){
        register_post_type('wdl_document', array(
            'labels'=>array('name'=>'Документы','singular_name'=>'Документ','add_new_item'=>'Добавить документ','edit_item'=>'Редактировать документ','menu_name'=>'Библиотека документов'),
            'public'=>true,'has_archive'=>true,'rewrite'=>array('slug'=>WDL_Settings::get_option('archive_slug','documents')),
            'supports'=>array('title','editor','thumbnail','excerpt','page-attributes'),'show_in_rest'=>true,'menu_icon'=>'dashicons-media-document'
        ));
    }
}
