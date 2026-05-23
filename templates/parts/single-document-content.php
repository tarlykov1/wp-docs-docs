<?php
if (! defined('ABSPATH')) exit;
$post_id=get_the_ID()?:get_queried_object_id(); if(!$post_id){return;}
$file_id=absint(get_post_meta($post_id,'_wdl_file_id',true));
$file_url=(string)($file_id?wp_get_attachment_url($file_id):get_post_meta($post_id,'_wdl_file_url',true));
$description=(string)get_post_meta($post_id,'_wdl_card_description',true);
$summary=$description?:((has_excerpt($post_id))?(string)get_the_excerpt($post_id):'');
$helpers=WDL_Plugin::get_instance()->helpers;
$file_type=strtoupper((string)$helpers->get_file_ext($file_url));
$file_size=''; if($file_id){$p=get_attached_file($file_id); if($p&&file_exists($p)){$file_size=size_format(filesize($p));}}
$file_info_rows=array_filter(array('Тип файла'=>$file_type,'Размер файла'=>$file_size));
$important=$helpers->is_truthy(get_post_meta($post_id,'_wdl_important',true));
$is_new=$helpers->is_truthy(get_post_meta($post_id,'_wdl_new',true));
$show_pdf=$helpers->is_truthy(get_post_meta($post_id,'_wdl_pdf_viewer',true));
$terms=get_the_terms($post_id,'wdl_document_category');
$crumbs=array('<a href="'.esc_url(get_post_type_archive_link('wdl_document')).'">Библиотека документов</a>');
if(!is_wp_error($terms)&&!empty($terms)){$term=array_shift($terms);foreach(array_reverse(get_ancestors($term->term_id,'wdl_document_category')) as $aid){$at=get_term($aid,'wdl_document_category');if($at&&!is_wp_error($at)){$crumbs[]='<a href="'.esc_url(get_term_link($at)).'">'.esc_html($at->name).'</a>';}}$crumbs[]='<a href="'.esc_url(get_term_link($term)).'">'.esc_html($term->name).'</a>';}
$crumbs[]=esc_html(get_the_title($post_id));
?>
<nav class="wdl-breadcrumbs" aria-label="Хлебные крошки"><?php echo wp_kses_post(implode(' / ',$crumbs)); ?></nav>
<article class="wpdl-document-page wpdl-single-document wdl-single"><div class="wpdl-document-layout wpdl-single-document-layout"><div class="wpdl-document-thumbnail wpdl-single-document-thumbnail"><?php echo wp_kses_post($helpers->get_thumb_or_icon($post_id,$file_url,'medium')); ?></div><div class="wpdl-document-content wpdl-single-document-content"><h1 class="wpdl-document-title wpdl-single-document-title"><?php the_title(); ?></h1><?php if($important||$is_new):?><div class="wdl-badges"><?php if($important):?><span class="wdl-badge wdl-badge-important">Важный</span><?php endif; ?><?php if($is_new):?><span class="wdl-badge wdl-badge-new">Новый</span><?php endif; ?></div><?php endif; ?><?php if($summary!==''):?><p class="wpdl-single-document-summary"><?php echo esc_html($summary); ?></p><?php endif; ?><?php if(!empty($file_info_rows)):?><section class="wpdl-document-file-info wpdl-single-document-file-info"><h2>Информация о файле</h2><dl><?php foreach($file_info_rows as $label=>$value):?><div class="wpdl-document-meta-row"><dt><?php echo esc_html($label); ?></dt><dd><?php echo esc_html($value); ?></dd></div><?php endforeach; ?></dl></section><?php endif; ?><?php if($file_url!==''):?><div class="wpdl-document-actions wpdl-single-document-actions"><a href="<?php echo esc_url($file_url); ?>" download class="wpdl-button wpdl-button-download">Скачать</a><a href="<?php echo esc_url($file_url); ?>" target="_blank" rel="noopener noreferrer" class="wpdl-button wpdl-button-open">Открыть</a></div><?php endif; ?><?php if($show_pdf&&$file_url!==''&&$helpers->is_pdf($file_url)):?><section class="wdl-document-viewer-section"><button type="button" class="wdl-viewer-toggle" aria-expanded="false" data-text-open="Посмотреть документ" data-text-close="Скрыть документ">Посмотреть документ</button><div class="wdl-document-viewer-wrap" hidden><iframe src="<?php echo esc_url($file_url); ?>" class="wdl-pdf-viewer" loading="lazy"></iframe></div></section><?php endif; ?></div></div></article>
