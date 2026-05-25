<?php
if (! defined('ABSPATH')) { exit; }
get_header();

$term = get_queried_object();
if (! ($term instanceof WP_Term) || 'wdl_document_category' !== $term->taxonomy) {
    get_footer();
    return;
}

$helpers = WDL_Plugin::get_instance()->helpers;
$library_url = $helpers->get_library_page_url();

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
$has_documents = $q->have_posts();

$data = array(
    'query' => $q,
    'atts' => array('view' => 'table', 'show_search' => 'yes'),
    'helpers' => WDL_Plugin::get_instance()->helpers,
);
?>
<div id="primary" class="content-area wdl-taxonomy-page">
    <main id="main" class="site-main">
        <article class="inside-article">
            <div class="entry-content wdl-library-container">
                <!-- WDL TAXONOMY DOCUMENT CATEGORY TEMPLATE LOADED -->
        <?php $helpers->render_breadcrumbs(array(array('label' => 'Библиотека документов', 'url' => $library_url), array('label' => $term->name))); ?>

        <header class="wdl-taxonomy-header">
            <h1 class="wdl-taxonomy-title"><?php echo esc_html($term->name); ?></h1>
            <?php if (! empty($term->description)) : ?><div class="wdl-taxonomy-description"><?php echo wp_kses_post(wpautop($term->description)); ?></div><?php endif; ?>
        </header>

                <?php if ($has_documents) : ?>
                    <?php include WDL_PLUGIN_DIR . 'templates/parts/document-library-list.php'; ?>
                <?php else : ?>
                    <div class="wdl-empty wdl-category-empty">В этой категории пока нет документов.</div>
                <?php endif; ?>
            </div>
        </article>
    </main>
</div>
<?php
wp_reset_postdata();
get_sidebar();
get_footer();
