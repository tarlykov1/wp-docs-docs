<?php
if (! defined('ABSPATH')) { exit; }
$default_view = ! empty($data['atts']['view']) ? (string) $data['atts']['view'] : 'table';
$default_view = in_array($default_view, array('table','cards'), true) ? $default_view : 'table';
$show_search = isset($data['atts']['show_search']) ? (string) $data['atts']['show_search'] : 'yes';
?>
<!-- WDL LIBRARY PARTIAL VERSION 1.1.6 -->
<div class="wdl-library" data-default-view="<?php echo esc_attr($default_view); ?>" data-view-storage-key="wdl_library_view_v2">
    <div class="wdl-library-toolbar">
        <?php if ('yes' === $show_search) : ?>
            <div class="wdl-library-search">
                <label class="wdl-search-label" for="wdl-search-input-<?php echo esc_attr(wp_unique_id()); ?>">Поиск документов</label>
                <input class="wdl-search-input" type="search" placeholder="Введите название или описание" />
            </div>
        <?php endif; ?>

        <div class="wdl-library-sort">
            <label class="wdl-search-label" for="wdl-sort-select">Сортировка</label>
            <select id="wdl-sort-select" class="wdl-sort-select">
                <option value="manual">По ручному порядку</option>
                <option value="title_asc">По названию А–Я</option>
                <option value="title_desc">По названию Я–А</option>
                <option value="date_desc">Сначала новые</option>
                <option value="date_asc">Сначала старые</option>
                <option value="size_desc">По размеру файла</option>
                <option value="type_asc">По типу файла</option>
            </select>
        </div>
        <div class="wdl-view-toggle" role="group" aria-label="Вид отображения">
            <button type="button" class="wdl-toggle-button" data-view="table" title="Показать в виде таблицы" aria-label="Таблица"><span aria-hidden="true">☷</span></button>
            <button type="button" class="wdl-toggle-button" data-view="cards" title="Показать в виде карточек" aria-label="Карточки"><span aria-hidden="true">▦</span></button>
        </div>
    </div>

    <div class="wdl-library-results">
        <div class="wdl-view-container" data-view="table"><?php include WDL_PLUGIN_DIR . 'templates/document-table.php'; ?></div>
        <div class="wdl-view-container" data-view="cards"><?php include WDL_PLUGIN_DIR . 'templates/document-cards.php'; ?></div>
    </div>

    <div class="wdl-empty-message" hidden>Документы не найдены</div>
</div>
