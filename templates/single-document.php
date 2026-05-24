<?php
defined('ABSPATH') || exit;

get_header();

echo '<!-- WDL SINGLE DOCUMENT TEMPLATE LOADED -->';
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="wdl-single-document-page">
            <?php
            $partial = plugin_dir_path(__FILE__) . 'parts/single-document-content.php';
            if (file_exists($partial)) {
                include $partial;
            } else {
                echo '<p>Шаблон документа не найден.</p>';
            }
            ?>
        </div>
    </main>
</div>
<?php
get_sidebar();
get_footer();
