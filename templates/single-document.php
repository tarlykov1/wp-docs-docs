<?php
get_header();
?>
<!-- FONDPP DOCUMENT LIBRARY SINGLE TEMPLATE LOADED -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php include WDL_PLUGIN_DIR . 'templates/parts/single-document-content.php'; ?>
<?php endwhile; endif; ?>
<?php
get_footer();
