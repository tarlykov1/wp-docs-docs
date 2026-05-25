<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Helpers {
    public function get_meta($id,$k,$d=''){ $v=get_post_meta($id,$k,true); return ''!==$v?$v:$d; }
    public function get_file_ext($url){ return strtolower(pathinfo((string)$url, PATHINFO_EXTENSION)); }
    public function is_pdf($url){ return 'pdf' === $this->get_file_ext($url); }
    public function is_truthy($value){
        if (is_bool($value)) return $value;
        $value = is_string($value) ? strtolower(trim($value)) : $value;
        return in_array($value,array(1,'1','on','yes','true'),true);
    }
    public function get_icon_class($ext){ $map=array('pdf'=>'wdl-icon-pdf','doc'=>'wdl-icon-doc','docx'=>'wdl-icon-doc','xls'=>'wdl-icon-xls','xlsx'=>'wdl-icon-xls','ppt'=>'wdl-icon-ppt','pptx'=>'wdl-icon-ppt','zip'=>'wdl-icon-zip','jpg'=>'wdl-icon-image','jpeg'=>'wdl-icon-image','png'=>'wdl-icon-image'); return $map[$ext]??'wdl-icon-file'; }
    public function get_default_thumbnail_url(){
        $id=absint(WDL_Settings::get_option('default_thumbnail_id',0));
        if($id){ $url=wp_get_attachment_image_url($id,'medium'); if($url){ return (string)$url; } }
        return WDL_PLUGIN_URL.'assets/images/default-document.svg';
    }
    public function get_thumb_or_icon($post_id,$url,$size='thumbnail'){
        if (has_post_thumbnail($post_id)) { return get_the_post_thumbnail($post_id,$size,array('class'=>'wdl-document-thumbnail','loading'=>'lazy')); }
        $fallback=$this->get_default_thumbnail_url();
        if($fallback){ return '<img src="'.esc_url($fallback).'" class="wdl-document-thumbnail wdl-document-thumbnail-fallback" alt="" loading="lazy">'; }
        return '<span class="wdl-document-icon '.esc_attr($this->get_icon_class($this->get_file_ext($url))).'">'.esc_html(strtoupper($this->get_file_ext($url) ?: 'FILE')).'</span>';
    }

    public function get_library_page_url(){
        $library_page_id = absint(WDL_Settings::get_option('wdl_library_page_id', 0));
        $library_url = $library_page_id ? get_permalink($library_page_id) : '';

        if (! $library_url) {
            $pages = get_posts(array('post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids', 's' => '[document_library]'));
            if (! empty($pages)) {
                $library_url = get_permalink((int) $pages[0]);
            }
        }

        if (! $library_url) {
            $library_url = home_url('/biblioteka-fonda/');
        }

        return (string) $library_url;
    }

    public function get_primary_document_category($post_id){
        $terms = wp_get_object_terms((int) $post_id, 'wdl_document_category', array('orderby' => 'term_order', 'order' => 'ASC'));
        if (is_wp_error($terms) || empty($terms)) {
            return null;
        }

        $term = reset($terms);
        return $term instanceof WP_Term ? $term : null;
    }

    public function render_breadcrumbs($items){
        $items = is_array($items) ? array_values(array_filter($items, static function($item){
            return is_array($item) && ! empty($item['label']);
        })) : array();

        if (empty($items)) {
            return;
        }

        include WDL_PLUGIN_DIR . 'templates/parts/breadcrumbs.php';
    }
}
