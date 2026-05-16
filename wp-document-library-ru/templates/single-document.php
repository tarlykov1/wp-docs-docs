<?php get_header(); while (have_posts()) : the_post();
    $u = get_post_meta(get_the_ID(), '_wdl_file_url', true);
    $description = get_post_meta(get_the_ID(), '_wdl_card_description', true);
    ?>
    <article class="wdl-single">
        <div class="wdl-single-cover"><?php echo wp_kses_post(get_the_post_thumbnail(get_the_ID(), 'medium')); ?></div>
        <div class="wdl-single-content">
            <h1><?php the_title(); ?></h1>
            <?php if (!empty($description)) : ?><p class="wdl-single-description"><?php echo esc_html($description); ?></p><?php endif; ?>
            <div class="wdl-single-body"><?php the_content(); ?></div>
            <?php if ($u) : ?><p><a class="wdl-button wdl-button-download" href="<?php echo esc_url($u); ?>" target="_blank" rel="noopener">Скачать документ</a></p><?php endif; ?>
        </div>
    </article>
<?php endwhile; get_footer();
