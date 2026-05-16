<div class="wdl-library" data-default-view="<?php echo esc_attr($data['atts']['view']); ?>">
    <div class="wdl-library-controls">
        <?php if ('yes' === $data['atts']['show_search']) : ?>
            <label class="wdl-search-label" for="wdl-search-input">Поиск документов</label>
            <input id="wdl-search-input" class="wdl-search-input" type="search" placeholder="Введите название, категорию, формат или версию" />
        <?php endif; ?>

        <div class="wdl-view-toggle" role="group" aria-label="Вид отображения">
            <button type="button" class="wdl-toggle-button" data-view="table">Таблица</button>
            <button type="button" class="wdl-toggle-button" data-view="cards">Карточки</button>
        </div>
    </div>

    <div class="wdl-view-container" data-view="table">
        <?php include WDL_PLUGIN_DIR . 'templates/document-table.php'; ?>
    </div>

    <div class="wdl-view-container" data-view="cards">
        <?php include WDL_PLUGIN_DIR . 'templates/document-cards.php'; ?>
    </div>

    <div class="wdl-no-results" hidden>Документы не найдены</div>
</div>
