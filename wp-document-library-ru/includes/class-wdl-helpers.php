<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Helpers {
    public function get_meta($id,$k,$d=''){ $v=get_post_meta($id,$k,true); return ''!==$v?$v:$d; }
    public function get_file_ext($url){ return strtolower(pathinfo((string)$url, PATHINFO_EXTENSION)); }
    public function is_pdf($url){ return 'pdf' === $this->get_file_ext($url); }
    public function get_icon_class($ext){ $map=array('pdf'=>'wdl-icon-pdf','doc'=>'wdl-icon-doc','docx'=>'wdl-icon-doc','xls'=>'wdl-icon-xls','xlsx'=>'wdl-icon-xls','ppt'=>'wdl-icon-ppt','pptx'=>'wdl-icon-ppt','zip'=>'wdl-icon-zip','jpg'=>'wdl-icon-image','jpeg'=>'wdl-icon-image','png'=>'wdl-icon-image'); return $map[$ext]??'wdl-icon-file'; }
    public function get_thumb_or_icon($post_id,$url,$size='thumbnail'){
        if (has_post_thumbnail($post_id)) { return get_the_post_thumbnail($post_id,$size,array('class'=>'wdl-document-thumbnail')); }
        return '<span class="wdl-document-icon '.esc_attr($this->get_icon_class($this->get_file_ext($url))).'">'.esc_html(strtoupper($this->get_file_ext($url) ?: 'FILE')).'</span>';
    }
}
