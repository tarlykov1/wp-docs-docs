<?php get_header(); while (have_posts()) : the_post();
    $u = get_post_meta(get_the_ID(), '_wdl_file_url', true);
    $description = get_post_meta(get_the_ID(), '_wdl_card_description', true);
    $thumb_width = absint(WDL_Settings::get_option('single_thumb_width', 200));
    $thumb_width = $thumb_width > 0 ? $thumb_width : 200;
    $terms = get_the_terms(get_the_ID(), 'wdl_document_category');
    $category_name = (!is_wp_error($terms) && !empty($terms)) ? $terms[0]->name : '';
    ?>
    <article class="wdl-single">
        <?php if ($category_name) : ?>
            <nav class="wdl-breadcrumbs" aria-label="Хлебные крошки">
                <a href="<?php echo esc_url(get_post_type_archive_link('wdl_document')); ?>">Каталог документов</a> <span>/</span> <span><?php echo esc_html($category_name); ?></span>
            </nav>
        <?php endif; ?>
        <div class="wdl-single-content">
            <div class="wdl-single-cover" style="width: <?php echo esc_attr($thumb_width); ?>px; max-width: 100%;">
                <?php echo wp_kses_post(get_the_post_thumbnail(get_the_ID(), 'medium')); ?>
            </div>
            <h1><?php the_title(); ?></h1>
            <?php if (!empty($description)) : ?><p class="wdl-single-description"><?php echo esc_html($description); ?></p><?php endif; ?>
            <div class="wdl-single-body"><?php the_content(); ?></div>
            <?php if ($u) : ?><p><a class="wdl-button wdl-button-download" href="<?php echo esc_url($u); ?>" target="_blank" rel="noopener">Скачать документ</a></p><?php endif; ?>
        </div>
    </article>
<?php endwhile; get_footer();
