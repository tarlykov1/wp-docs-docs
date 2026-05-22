<div class="wdl-document-list">
    <?php if ($data['query']->have_posts()) : while ($data['query']->have_posts()) : $data['query']->the_post();
        $u = get_post_meta(get_the_ID(), '_wdl_file_url', true);
        $description = get_post_meta(get_the_ID(), '_wdl_card_description', true);
        $ext = strtoupper($data['helpers']->get_file_ext($u));
        $file_id = absint(get_post_meta(get_the_ID(), '_wdl_file_id', true));
        $size_label = '';
        if ($file_id) {
            $file_path = get_attached_file($file_id);
            if ($file_path && file_exists($file_path)) {
                $size_label = size_format(filesize($file_path));
            }
        }
        ?>
        <article class="wdl-item" data-search="<?php echo esc_attr(strtolower(trim(get_the_title() . ' ' . $description . ' ' . $ext . ' ' . $size_label))); ?>">
            <div class="wdl-doc-row">
                <div class="wdl-doc-thumb"><?php echo $data['helpers']->get_thumb_or_icon(get_the_ID(), $u, 'medium'); ?></div>
                <div class="wdl-doc-content">
                    <h3 class="wdl-doc-title"><?php the_title(); ?></h3>
                    <p class="wdl-doc-description"><?php echo esc_html($description); ?></p>
                    <p class="wdl-doc-meta"><?php echo esc_html(trim($ext . ($size_label ? ' • ' . $size_label : ''))); ?></p>
                </div>
                <?php if ($u) : ?>
                    <div class="wdl-doc-actions"><a class="wdl-button wdl-button-download wdl-button-small" href="<?php echo esc_url($u); ?>" target="_blank" rel="noopener">Скачать</a></div>
                <?php endif; ?>
            </div>
        </article>
    <?php endwhile; else : ?>
        <div>Документы не найдены</div>
    <?php endif; ?>
</div>
