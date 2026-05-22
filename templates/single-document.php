<?php
get_header();
while (have_posts()) :
    the_post();

    $post_id         = get_the_ID();
    $description     = get_post_meta($post_id, '_wdl_card_description', true);
    $version         = get_post_meta($post_id, '_wdl_version', true);
    $updated_date    = get_post_meta($post_id, '_wdl_updated_date', true);
    $owner           = get_post_meta($post_id, '_wdl_owner', true);
    $doc_number      = get_post_meta($post_id, '_wdl_doc_number', true);
    $expiry_date     = get_post_meta($post_id, '_wdl_expiry_date', true);
    $pages_count     = get_post_meta($post_id, '_wdl_pages_count', true);
    $file_id         = absint(get_post_meta($post_id, '_wdl_file_id', true));
    $file_url_meta   = get_post_meta($post_id, '_wdl_file_url', true);
    $file_url        = $file_id ? wp_get_attachment_url($file_id) : $file_url_meta;
    $show_download   = (bool) get_post_meta($post_id, '_wdl_show_download', true);
    $thumb_width     = max(80, absint(WDL_Settings::get_option('single_thumb_width', 160)));
    $thumb_height_op = WDL_Settings::get_option('single_thumb_height', 'auto');
    $thumb_height    = ('auto' === strtolower((string) $thumb_height_op)) ? 'auto' : max(80, absint($thumb_height_op));

    $terms           = get_the_terms($post_id, 'wdl_document_category');
    $category_name   = (! is_wp_error($terms) && ! empty($terms)) ? $terms[0]->name : '';

    $meta_rows = array_filter([
        'Номер документа' => $doc_number,
        'Версия' => $version,
        'Ответственный' => $owner,
        'Дата обновления' => $updated_date,
        'Срок действия' => $expiry_date,
    ], static function ($v) { return '' !== (string) $v; });

    $file_name = '';
    $file_ext = '';
    $file_size = '';
    $file_uploaded = '';

    if ($file_id) {
        $file_name = get_the_title($file_id);
        $attached_path = get_attached_file($file_id);
        if ($attached_path && file_exists($attached_path)) {
            $file_size = size_format(filesize($attached_path));
            $file_ext = strtoupper(pathinfo($attached_path, PATHINFO_EXTENSION));
        }
        $upload_date = get_the_date('d.m.Y', $file_id);
        if ($upload_date) {
            $file_uploaded = $upload_date;
        }
    }

    if (! $file_ext && $file_url) {
        $file_ext = strtoupper(pathinfo((string) $file_url, PATHINFO_EXTENSION));
    }

    $file_info_rows = array_filter([
        'Название файла' => $file_name,
        'Тип файла' => $file_ext,
        'Размер файла' => $file_size,
        'Дата загрузки' => $file_uploaded,
        'Количество страниц' => $pages_count,
        'Категория' => $category_name,
    ], static function ($v) { return '' !== (string) $v; });
    ?>

    <article class="wpdl-document-page wdl-single">
        <div class="wpdl-document-layout">
            <?php if (has_post_thumbnail($post_id)) : ?>
                <div class="wpdl-document-thumbnail" style="max-width: <?php echo esc_attr($thumb_width); ?>px; <?php if ('auto' !== $thumb_height) : ?>height: <?php echo esc_attr($thumb_height); ?>px;<?php endif; ?>">
                    <?php echo wp_kses_post(get_the_post_thumbnail($post_id, 'medium')); ?>
                </div>
            <?php endif; ?>

            <div class="wpdl-document-content">
                <h1 class="wpdl-document-title"><?php the_title(); ?></h1>

                <?php if (! empty($description)) : ?>
                    <section class="wpdl-document-description">
                        <h2>Описание</h2>
                        <div><?php echo wp_kses_post(wpautop($description)); ?></div>
                    </section>
                <?php endif; ?>

                <?php if (! empty($meta_rows)) : ?>
                    <dl class="wpdl-document-meta">
                        <?php foreach ($meta_rows as $label => $value) : ?>
                            <div class="wpdl-document-meta-row">
                                <dt><?php echo esc_html($label); ?></dt>
                                <dd><?php echo esc_html($value); ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                <?php endif; ?>

                <?php if (! empty($file_info_rows)) : ?>
                    <section class="wpdl-document-file-info">
                        <h2>Информация о файле</h2>
                        <dl>
                            <?php foreach ($file_info_rows as $label => $value) : ?>
                                <div class="wpdl-document-meta-row">
                                    <dt><?php echo esc_html($label); ?></dt>
                                    <dd><?php echo esc_html($value); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    </section>
                <?php endif; ?>

                <?php if ($file_url && $show_download) : ?>
                    <div class="wpdl-document-actions">
                        <a href="<?php echo esc_url($file_url); ?>" download class="wpdl-button wpdl-button-download">Скачать</a>
                        <a href="<?php echo esc_url($file_url); ?>" target="_blank" rel="noopener noreferrer" class="wpdl-button wpdl-button-open">Открыть</a>
                    </div>
                <?php endif; ?>

                <div class="wdl-single-body"><?php the_content(); ?></div>
            </div>
        </div>
    </article>
<?php endwhile; get_footer();
