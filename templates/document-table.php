<div class="wdl-document-list">
    <table class="wdl-document-table">
        <thead>
            <tr>
                <th class="wdl-col-thumb">Превью</th>
                <th>Документ</th>
                <th class="wdl-col-type">Тип</th>
                <th class="wdl-col-size">Размер</th>
                <th class="wdl-col-actions">Действие</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($data['query']->have_posts()) : while ($data['query']->have_posts()) : $data['query']->the_post();
            $u = get_post_meta(get_the_ID(), '_wdl_file_url', true);
            $description = (string) get_post_meta(get_the_ID(), '_wdl_card_description', true);
            $important = WDL_Plugin::get_instance()->helpers->is_truthy(get_post_meta(get_the_ID(), '_wdl_important', true));
            $is_new = WDL_Plugin::get_instance()->helpers->is_truthy(get_post_meta(get_the_ID(), '_wdl_new', true));
            $ext = strtoupper($data['helpers']->get_file_ext($u));
            $file_id = absint(get_post_meta(get_the_ID(), '_wdl_file_id', true));
            $size_label = '';
            $show_download_catalog = (bool) WDL_Settings::get_option('show_download_in_catalog', 0);
            if ($file_id) {
                $file_path = get_attached_file($file_id);
                if ($file_path && file_exists($file_path)) {
                    $size_label = size_format(filesize($file_path));
                }
            }
            $manual_order = get_post_meta(get_the_ID(), '_wdl_manual_order', true);
            $manual_order = ($manual_order === '' || $manual_order === null) ? 999999 : absint($manual_order);
            $file_size = ($file_id && ! empty($file_path) && file_exists($file_path)) ? (int) filesize($file_path) : 0;
            ?>
            <tr class="wdl-item wdl-document-item" data-doc-id="<?php echo esc_attr(get_the_ID()); ?>" data-search="<?php echo esc_attr(strtolower(trim(get_the_title() . ' ' . $description . ' ' . $ext . ' ' . $size_label))); ?>" data-wdl-item data-title="<?php echo esc_attr(get_the_title()); ?>" data-summary="<?php echo esc_attr($description); ?>" data-date="<?php echo esc_attr(get_the_date('Y-m-d')); ?>" data-order="<?php echo esc_attr($manual_order); ?>" data-file-size="<?php echo esc_attr($file_size); ?>" data-file-type="<?php echo esc_attr(strtolower($ext)); ?>">
                <td class="wdl-doc-thumb" data-label="Превью"><a class="wdl-doc-thumb-link" href="<?php echo esc_url(get_permalink()); ?>"><?php echo $data['helpers']->get_thumb_or_icon(get_the_ID(), $u, 'thumbnail'); ?></a></td>
                <td data-label="Документ">
                    <h3 class="wdl-doc-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                    <p class="wdl-doc-description"><?php echo esc_html($description); ?></p>
                    <?php if ($important || $is_new) : ?><div class="wdl-badges"><?php if ($important) : ?><span class="wdl-badge wdl-badge-important">Важный</span><?php endif; ?><?php if ($is_new) : ?><span class="wdl-badge wdl-badge-new">Новый</span><?php endif; ?></div><?php endif; ?>
                </td>
                <td data-label="Тип"><?php echo esc_html($ext ?: '—'); ?></td>
                <td data-label="Размер"><?php echo esc_html($size_label ?: '—'); ?></td>
                <td data-label="Действие">
                    <a class="wdl-button wdl-button-small" href="<?php echo esc_url(get_permalink()); ?>">Открыть</a>
                    <?php if ($show_download_catalog && $u) : ?>
                        <a class="wdl-button wdl-button-download wdl-button-small" href="<?php echo esc_url($u); ?>" target="_blank" rel="noopener">Скачать</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; else : ?>
            <tr><td colspan="5">Документы не найдены</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
