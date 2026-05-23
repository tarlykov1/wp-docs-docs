<div class="wdl-cards">
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
    ?>
    <article class="wdl-document-card wdl-item" data-search="<?php echo esc_attr(strtolower(trim(get_the_title() . ' ' . $description . ' ' . $ext . ' ' . $size_label))); ?>" data-title="<?php echo esc_attr(get_the_title()); ?>" data-summary="<?php echo esc_attr($description); ?>">
        <div class="wdl-card-top">
            <div class="wdl-card-thumb"><a class="wdl-doc-thumb-link" href="<?php echo esc_url(get_permalink()); ?>"><?php echo $data['helpers']->get_thumb_or_icon(get_the_ID(), $u, 'medium'); ?></a></div>
            <?php if ($show_download_catalog && $u) : ?><a class="wdl-button wdl-button-download wdl-button-small" href="<?php echo esc_url($u); ?>" target="_blank" rel="noopener">Скачать</a><?php endif; ?>
        </div>
        <h3 class="wdl-doc-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
        <p class="wdl-doc-description"><?php echo esc_html($description); ?></p>
        <?php if ($important || $is_new) : ?><div class="wdl-badges"><?php if ($important) : ?><span class="wdl-badge wdl-badge-important">Важный</span><?php endif; ?><?php if ($is_new) : ?><span class="wdl-badge wdl-badge-new">Новый</span><?php endif; ?></div><?php endif; ?><p class="wdl-doc-meta"><?php echo esc_html(trim($ext . ($size_label ? ' • ' . $size_label : ''))); ?></p>
    </article>
<?php endwhile; else : ?><div>Документы не найдены</div><?php endif; ?>
</div>
