<table class="wdl-document-table">
    <thead>
    <tr>
        <th>Документ</th>
        <th>Описание</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if ($data['query']->have_posts()) : while ($data['query']->have_posts()) : $data['query']->the_post();
        $u = get_post_meta(get_the_ID(), '_wdl_file_url', true);
        $description = get_post_meta(get_the_ID(), '_wdl_card_description', true);
        ?>
        <tr class="wdl-item" data-search="<?php echo esc_attr(strtolower(trim(get_the_title() . ' ' . $description))); ?>">
            <td class="wdl-doc-cell">
                <div class="wdl-doc-main">
                    <div class="wdl-doc-thumb"><?php echo $data['helpers']->get_thumb_or_icon(get_the_ID(), $u, 'medium'); ?></div>
                    <strong><?php the_title(); ?></strong>
                </div>
            </td>
            <td><?php echo esc_html($description); ?></td>
            <td class="wdl-actions-cell"><?php if ($u) : ?><a class="wdl-button wdl-button-download" href="<?php echo esc_url($u); ?>" target="_blank" rel="noopener">Скачать</a><?php endif; ?></td>
        </tr>
    <?php endwhile; else : ?>
        <tr><td colspan="3">Документы не найдены</td></tr>
    <?php endif; ?>
    </tbody>
</table>
