<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Meta_Boxes {
    private const DOCUMENT_CATEGORY_TAXONOMY = 'wdl_document_category';
    public function __construct(){ add_action('add_meta_boxes',array($this,'add')); add_action('save_post_wdl_document',array($this,'save')); add_action('admin_enqueue_scripts',array($this,'assets')); }
    public function add(){ add_meta_box('wdl_document_meta','Параметры документа',array($this,'render'),'wdl_document','normal','default'); }
    public function assets($hook){ if ('post.php'!==$hook && 'post-new.php'!==$hook) return; wp_enqueue_media(); wp_enqueue_script('wdl-admin',WDL_PLUGIN_URL.'assets/js/admin.js',array('jquery'),WDL_PLUGIN_VERSION,true); }
    public function render($post){ wp_nonce_field('wdl_save_meta','wdl_meta_nonce'); $fields=['file_id','file_url','version','updated_date','owner','doc_number','expiry_date','card_description','pdf_viewer','show_download','important','new','manual_order']; foreach($fields as $f){ $$f=get_post_meta($post->ID,'_wdl_'.$f,true);} $document_category_taxonomy = self::DOCUMENT_CATEGORY_TAXONOMY; $document_categories = get_terms(array('taxonomy' => $document_category_taxonomy, 'hide_empty' => false)); $current_terms = wp_get_object_terms($post->ID, $document_category_taxonomy, array('fields' => 'ids'));
        $selected_category_id = ! empty($current_terms) ? absint(reset($current_terms)) : 0;
        include WDL_PLUGIN_DIR.'templates/admin-metabox.php'; }
    public function save($post_id){
        if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) return;
        if (!isset($_POST['wdl_meta_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wdl_meta_nonce'])),'wdl_save_meta')) return;
        if (!current_user_can('edit_post',$post_id)) return; $text=['version','updated_date','owner','doc_number','expiry_date']; foreach($text as $k){ if(isset($_POST['wdl_'.$k])) update_post_meta($post_id,'_wdl_'.$k,sanitize_text_field(wp_unslash($_POST['wdl_'.$k]))); }
        if(isset($_POST['wdl_card_description'])) update_post_meta($post_id,'_wdl_card_description',sanitize_textarea_field(wp_unslash($_POST['wdl_card_description'])));
        if(isset($_POST['wdl_file_id'])) update_post_meta($post_id,'_wdl_file_id',absint($_POST['wdl_file_id']));
        if(isset($_POST['wdl_file_url'])) update_post_meta($post_id,'_wdl_file_url',esc_url_raw(wp_unslash($_POST['wdl_file_url'])));
        update_post_meta($post_id,'_wdl_manual_order',isset($_POST['wdl_manual_order'])?absint($_POST['wdl_manual_order']):0);
        foreach(['pdf_viewer','show_download','important','new'] as $c){ update_post_meta($post_id,'_wdl_'.$c,isset($_POST['wdl_'.$c])?1:0); }
                if (array_key_exists('wdl_document_category', $_POST)) {
            $term_id = absint(wp_unslash($_POST['wdl_document_category']));
            $term_exists = $term_id > 0 ? term_exists($term_id, self::DOCUMENT_CATEGORY_TAXONOMY) : 0;

            if ($term_id > 0 && $term_exists) {
                wp_set_object_terms($post_id, array($term_id), self::DOCUMENT_CATEGORY_TAXONOMY, false);
            } else {
                wp_set_object_terms($post_id, array(), self::DOCUMENT_CATEGORY_TAXONOMY, false);
            }
        }
    }
}
