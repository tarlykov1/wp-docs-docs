<div class="wdl-library" data-default-view="table">
    <div class="wdl-library-controls">
        <?php if ('yes' === $data['atts']['show_search']) : ?>
            <div class="wdl-search-wrap">
                <label class="wdl-search-label" for="wdl-search-input">Поиск документов</label>
                <input id="wdl-search-input" class="wdl-search-input" type="search" placeholder="Введите название или описание" />
            </div>
        <?php endif; ?>

        <div class="wdl-view-toggle" role="group" aria-label="Вид отображения">
            <button type="button" class="wdl-toggle-button" data-view="table" title="Показать в виде таблицы" aria-label="Таблица">
                <span aria-hidden="true">☷</span>
            </button>
            <button type="button" class="wdl-toggle-button" data-view="cards" title="Показать в виде карточек" aria-label="Карточки">
                <span aria-hidden="true">▦</span>
            </button>
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
