<?php
if (! defined('ABSPATH')) { exit; }
get_header();

$term = get_queried_object();
if (! ($term instanceof WP_Term) || 'wdl_document_category' !== $term->taxonomy) {
    get_footer();
    return;
}

$library_page_id = absint(WDL_Settings::get_option('wdl_library_page_id', 0));
$library_url = $library_page_id ? get_permalink($library_page_id) : '';
if (! $library_url) {
    $pages = get_posts(array('post_type' => 'page','post_status' => 'publish','posts_per_page' => 1,'fields' => 'ids','s' => '[document_library]'));
    if (! empty($pages)) { $library_url = get_permalink((int) $pages[0]); }
}
if (! $library_url) { $library_url = home_url('/biblioteka-fonda/'); }

$query_args = array(
    'post_type' => 'wdl_document',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_key' => '_wdl_manual_order',
    'orderby' => array('meta_value_num' => 'ASC', 'date' => 'DESC', 'title' => 'ASC'),
    'tax_query' => array(
        array(
            'taxonomy' => 'wdl_document_category',
            'field'    => 'term_id',
            'terms'    => $term->term_id,
        ),
    ),
);
$q = new WP_Query($query_args);

$data = array(
    'query' => $q,
    'atts' => array('view' => 'table', 'show_search' => 'yes'),
    'helpers' => WDL_Plugin::get_instance()->helpers,
);
?>
<main id="primary" class="site-main wdl-taxonomy-page">
    <div class="wdl-library-container">
        <nav class="wdl-breadcrumbs" aria-label="Хлебные крошки">
            <a href="<?php echo esc_url($library_url); ?>">Библиотека документов</a> / <?php echo esc_html($term->name); ?>
        </nav>

        <header class="wdl-taxonomy-header">
            <h1 class="wdl-taxonomy-title"><?php echo esc_html($term->name); ?></h1>
            <?php if (! empty($term->description)) : ?><div class="wdl-taxonomy-description"><?php echo wp_kses_post(wpautop($term->description)); ?></div><?php endif; ?>
        </header>

        <?php include WDL_PLUGIN_DIR . 'templates/parts/document-library-list.php'; ?>
    </div>
</main>
<?php
wp_reset_postdata();
get_footer();
