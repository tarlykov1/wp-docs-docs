<!-- FONDPP SINGLE DOCUMENT TEMPLATE FILE LOADED 1.0.8 -->
<?php
get_header();
?>
<!-- FONDPP DOCUMENT LIBRARY SINGLE TEMPLATE LOADED -->

<main id="primary" class="site-main fondpp-document-single-page">
    <div class="inside-article fondpp-document-single-container">
        <?php
        include plugin_dir_path(dirname(__FILE__)) . 'templates/parts/single-document-content.php';
        ?>
    </div>
</main>

<?php get_sidebar(); ?>

<?php
get_footer();
