<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<!-- FONDPP DOCUMENT LIBRARY SINGLE CONTENT LOADED -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
$post_id = get_the_ID();
$file_id = absint(get_post_meta($post_id, '_wdl_file_id', true));
$file_url_meta = (string) get_post_meta($post_id, '_wdl_file_url', true);
$file_url_from_attachment = $file_id ? (string) wp_get_attachment_url($file_id) : '';
$file_url = $file_url_from_attachment !== '' ? $file_url_from_attachment : $file_url_meta;

$description = (string) get_post_meta($post_id, '_wdl_card_description', true);
$subtitle = (string) get_post_meta($post_id, '_wdl_subtitle', true);
$summary = $subtitle !== '' ? $subtitle : $description;
if ($summary === '' && has_excerpt($post_id)) {
    $summary = (string) get_the_excerpt($post_id);
}

$file_name = '';
$file_size = '';
$upload_date = '';
if ($file_id) {
    $file_name = (string) get_the_title($file_id);
    $attached_path = get_attached_file($file_id);
    if ($attached_path && file_exists($attached_path)) {
        $file_size = (string) size_format(filesize($attached_path));
    }
    $upload_date = (string) get_the_date('d.m.Y', $file_id);
}

$file_type = strtoupper((string) WDL_Plugin::get_instance()->helpers->get_file_ext($file_url));
$terms = get_the_terms($post_id, 'wdl_document_category');
$category = (! is_wp_error($terms) && ! empty($terms)) ? (string) $terms[0]->name : '';

$meta_rows = array_filter(array(
    'Номер документа' => (string) get_post_meta($post_id, '_wdl_doc_number', true),
    'Версия' => (string) get_post_meta($post_id, '_wdl_version', true),
    'Ответственный' => (string) get_post_meta($post_id, '_wdl_owner', true),
    'Дата обновления' => (string) get_post_meta($post_id, '_wdl_updated_date', true),
    'Срок действия' => (string) get_post_meta($post_id, '_wdl_expiry_date', true),
), static function ($value) {
    return trim((string) $value) !== '';
});

$file_info_rows = array_filter(array(
    'Название файла' => $file_name,
    'Тип файла' => $file_type,
    'Размер файла' => $file_size,
    'Дата загрузки' => $upload_date,
    'Категория' => $category,
), static function ($value) {
    return trim((string) $value) !== '';
});

$excluded_exact = array(
    '_edit_lock',
    '_edit_last',
    '_thumbnail_id',
    'ekit_post_views_count',
    '_wdl_file_id',
    '_wdl_file_url',
    '_wdl_card_description',
    '_wdl_doc_number',
    '_wdl_version',
    '_wdl_owner',
    '_wdl_updated_date',
    '_wdl_expiry_date',
    '_wdl_subtitle',
    '_wdl_show_download',
    '_wdl_pdf_viewer',
    '_wdl_important',
    '_wdl_new',
    '_wdl_manual_order',
);

$extra_meta_rows = array();
foreach (get_post_meta($post_id) as $meta_key => $values) {
    if (in_array($meta_key, $excluded_exact, true)) {
        continue;
    }
    if (strpos($meta_key, '_') === 0 || strpos($meta_key, 'elementor') !== false || strpos($meta_key, 'generate') !== false || strpos($meta_key, 'ekit') !== false) {
        continue;
    }

    $raw = isset($values[0]) ? maybe_unserialize($values[0]) : '';
    if (is_array($raw) || is_object($raw)) {
        continue;
    }

    $value = trim((string) $raw);
    if ($value === '') {
        continue;
    }

    $label = mb_convert_case(str_replace('_', ' ', $meta_key), MB_CASE_TITLE, 'UTF-8');
    $extra_meta_rows[$label] = sanitize_text_field($value);
}
?>
<article class="wpdl-document-page wpdl-single-document wdl-single">
    <div class="wpdl-document-layout wpdl-single-document-layout">
        <div class="wpdl-document-thumbnail wpdl-single-document-thumbnail">
            <?php echo wp_kses_post(WDL_Plugin::get_instance()->helpers->get_thumb_or_icon($post_id, $file_url, 'medium')); ?>
        </div>

        <div class="wpdl-document-content wpdl-single-document-content">
            <h1 class="wpdl-document-title wpdl-single-document-title"><?php the_title(); ?></h1>

            <?php if ($summary !== '') : ?>
                <p class="wpdl-single-document-summary"><?php echo esc_html($summary); ?></p>
            <?php endif; ?>

            <?php if ($description !== '' || get_the_content() !== '') : ?>
                <section class="wpdl-document-description wpdl-single-document-description">
                    <h2>Описание</h2>
                    <div><?php echo wp_kses_post(wpautop($description !== '' ? $description : get_the_content())); ?></div>
                </section>
            <?php endif; ?>

            <?php if (! empty($meta_rows) || ! empty($extra_meta_rows)) : ?>
                <section class="wpdl-single-document-fields">
                    <h2>Поля документа</h2>
                    <dl class="wpdl-document-meta">
                        <?php foreach ($meta_rows as $label => $value) : ?>
                            <div class="wpdl-document-meta-row"><dt><?php echo esc_html($label); ?></dt><dd><?php echo esc_html($value); ?></dd></div>
                        <?php endforeach; ?>
                        <?php foreach ($extra_meta_rows as $label => $value) : ?>
                            <div class="wpdl-document-meta-row"><dt><?php echo esc_html($label); ?></dt><dd><?php echo esc_html($value); ?></dd></div>
                        <?php endforeach; ?>
                    </dl>
                </section>
            <?php endif; ?>

            <?php if (! empty($file_info_rows)) : ?>
                <section class="wpdl-document-file-info wpdl-single-document-file-info">
                    <h2>Информация о файле</h2>
                    <dl>
                        <?php foreach ($file_info_rows as $label => $value) : ?>
                            <div class="wpdl-document-meta-row"><dt><?php echo esc_html($label); ?></dt><dd><?php echo esc_html($value); ?></dd></div>
                        <?php endforeach; ?>
                    </dl>
                </section>
            <?php endif; ?>

            <?php if ($file_url !== '') : ?>
                <div class="wpdl-document-actions wpdl-single-document-actions">
                    <a href="<?php echo esc_url($file_url); ?>" download class="wpdl-button wpdl-button-download">Скачать</a>
                    <a href="<?php echo esc_url($file_url); ?>" target="_blank" rel="noopener noreferrer" class="wpdl-button wpdl-button-open">Открыть</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>
<?php endwhile; endif; ?>
