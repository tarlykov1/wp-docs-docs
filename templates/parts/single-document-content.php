<?php
if (! defined('ABSPATH')) exit;
$post_id = get_queried_object_id();
if (! $post_id) {
    $post_id = get_the_ID();
}
if (! $post_id) { return; }

$file_id = absint(get_post_meta($post_id, '_wdl_file_id', true));
$raw_file_url = (string) ($file_id ? wp_get_attachment_url($file_id) : get_post_meta($post_id, '_wdl_file_url', true));
$file_url = str_replace('http://fondpp.org/', 'https://fondpp.org/', $raw_file_url);
$description = (string) get_post_meta($post_id, '_wdl_card_description', true);
$summary = $description ?: (has_excerpt($post_id) ? (string) get_the_excerpt($post_id) : '');
$helpers = WDL_Plugin::get_instance()->helpers;
$file_type = strtoupper((string) $helpers->get_file_ext($file_url));
$file_size = '';
if ($file_id) { $p = get_attached_file($file_id); if ($p && file_exists($p)) { $file_size = size_format(filesize($p)); }}
$file_info_rows = array_filter(array('Тип файла' => $file_type, 'Размер файла' => $file_size));
$important = $helpers->is_truthy(get_post_meta($post_id, '_wdl_important', true));
$is_new = $helpers->is_truthy(get_post_meta($post_id, '_wdl_new', true));
$show_pdf = $helpers->is_truthy(get_post_meta($post_id, '_wdl_pdf_viewer', true));
$content_raw = (string) get_post_field('post_content', $post_id);
$document_content = wpautop(do_shortcode($content_raw));
$has_document_content = ! empty(trim(wp_strip_all_tags($document_content)));

$library_url = $helpers->get_library_page_url();
$primary_category = $helpers->get_primary_document_category($post_id);

$breadcrumbs = array(
    array('label' => 'Библиотека документов', 'url' => $library_url),
);

if ($primary_category instanceof WP_Term) {
    $breadcrumbs[] = array(
        'label' => $primary_category->name,
        'url' => get_term_link($primary_category),
    );
}

$breadcrumbs[] = array('label' => get_the_title($post_id));
$helpers->render_breadcrumbs($breadcrumbs);
?>

<article class="wpdl-document-page wpdl-single-document wdl-single">
    <div class="wpdl-document-layout wpdl-single-document-layout">
        <div class="wpdl-document-thumbnail wpdl-single-document-thumbnail"><?php echo wp_kses_post($helpers->get_thumb_or_icon($post_id, $file_url, 'medium')); ?></div>
        <div class="wpdl-document-content wpdl-single-document-content">
            <h1 class="wpdl-document-title wpdl-single-document-title"><?php the_title(); ?></h1>
            <?php if ($has_document_content) : ?>
                <div class="wdl-document-content">
                    <?php echo wp_kses_post($document_content); ?>
                </div>
            <?php endif; ?>
            <?php if ($important || $is_new) : ?><div class="wdl-badges"><?php if ($important) : ?><span class="wdl-badge wdl-badge-important">Важный</span><?php endif; ?><?php if ($is_new) : ?><span class="wdl-badge wdl-badge-new">Новый</span><?php endif; ?></div><?php endif; ?>
            <?php if ($summary !== '') : ?><p class="wpdl-single-document-summary"><?php echo esc_html($summary); ?></p><?php endif; ?>
            <?php if (! empty($file_info_rows)) : ?>
                <section class="wpdl-document-file-info wpdl-single-document-file-info">
                    <h2>Информация о файле</h2>
                    <dl><?php foreach ($file_info_rows as $label => $value) : ?><div class="wpdl-document-meta-row wdl-info-row"><dt><?php echo esc_html($label); ?></dt><dd><?php echo esc_html($value); ?></dd></div><?php endforeach; ?></dl>
                </section>
            <?php endif; ?>
            <?php $show_download = $helpers->is_truthy(get_post_meta($post_id, '_wdl_show_download', true)); ?>
            <?php if ($file_url !== '') : ?><div class="wpdl-document-actions wpdl-single-document-actions"><?php if ($show_download) : ?><a href="<?php echo esc_url($file_url); ?>" download class="wdl-btn wdl-btn-primary">Скачать</a><?php endif; ?><a href="<?php echo esc_url($file_url); ?>" target="_blank" rel="noopener noreferrer" class="wdl-btn wdl-btn-outline-primary">Открыть</a></div><?php endif; ?>
        </div>
    </div>
</article>

<?php if ($show_pdf && $file_url !== '' && $helpers->is_pdf($file_url)) : ?>
<section class="wdl-document-viewer-section">
    <div class="wdl-document-viewer-header"><button type="button" class="wdl-btn wdl-btn-secondary wdl-viewer-toggle" aria-expanded="false" data-text-open="Посмотреть документ" data-text-close="Скрыть документ">Посмотреть документ</button></div>
    <div class="wdl-document-viewer-wrap" hidden><iframe src="<?php echo esc_url($file_url); ?>" class="wdl-pdf-viewer" loading="lazy"></iframe></div>
</section>
<?php endif; ?>
