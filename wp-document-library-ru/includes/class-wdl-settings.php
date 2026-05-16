<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Settings {
    const OPTION_KEY='wdl_settings';
    public function __construct(){ add_action('admin_init', array($this,'register_settings')); }
    public static function defaults(){ return array('default_view'=>'table','per_page'=>10,'show_search'=>1,'show_filters'=>1,'show_thumbnails'=>1,'show_date'=>1,'show_version'=>1,'show_size'=>1,'show_category'=>1,'show_open'=>1,'show_download'=>1,'pdf_height'=>700,'open_text'=>'Открыть','download_text'=>'Скачать','enable_single'=>1,'archive_slug'=>'documents'); }
    public static function get_option($key,$default=''){ $o=wp_parse_args((array)get_option(self::OPTION_KEY,array()), self::defaults()); return $o[$key]??$default; }
    public function register_settings(){ register_setting('wdl_settings_group',self::OPTION_KEY,array($this,'sanitize')); add_settings_section('wdl_main','Основные настройки','__return_false','wdl_settings'); }
    public function sanitize($input){ $d=self::defaults(); return array('default_view'=>in_array($input['default_view']??$d['default_view'],array('table','cards','compact','categories'),true)?$input['default_view']:$d['default_view'],'per_page'=>absint($input['per_page']??$d['per_page']),'show_search'=>!empty($input['show_search'])?1:0,'show_filters'=>!empty($input['show_filters'])?1:0,'show_thumbnails'=>!empty($input['show_thumbnails'])?1:0,'show_date'=>!empty($input['show_date'])?1:0,'show_version'=>!empty($input['show_version'])?1:0,'show_size'=>!empty($input['show_size'])?1:0,'show_category'=>!empty($input['show_category'])?1:0,'show_open'=>!empty($input['show_open'])?1:0,'show_download'=>!empty($input['show_download'])?1:0,'pdf_height'=>absint($input['pdf_height']??700),'open_text'=>sanitize_text_field($input['open_text']??'Открыть'),'download_text'=>sanitize_text_field($input['download_text']??'Скачать'),'enable_single'=>!empty($input['enable_single'])?1:0,'archive_slug'=>sanitize_title($input['archive_slug']??'documents')); }
}
