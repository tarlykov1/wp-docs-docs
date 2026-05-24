jQuery(function($){
    $('.wdl-categories-tree .wdl-category-item').on('click',function(){$(this).toggleClass('is-open');});

    $('.wdl-library').each(function(){
        var $library = $(this);
        var storageKey = ($library.data('view-storage-key') || 'wdl_library_view') + '_v2';
        var defaultView = ($library.data('default-view') === 'cards') ? 'cards' : 'table';
        var savedView = null;
        try { savedView = localStorage.getItem(storageKey); } catch(e) {}
        var initialView = (savedView === 'cards' || savedView === 'table') ? savedView : defaultView;

        var $containers = $library.find('.wdl-view-container');
        var $buttons = $library.find('.wdl-toggle-button');
        var $search = $library.find('.wdl-search-input');
        var $noResults = $library.find('.wdl-empty-message');
        var $sort = $library.find('.wdl-sort-select');

        function compareItems(a,b,mode){
            var da=$(a).data(), db=$(b).data();
            if(mode==='title_asc') return (da.title||'').localeCompare(db.title||'','ru');
            if(mode==='title_desc') return (db.title||'').localeCompare(da.title||'','ru');
            if(mode==='date_asc') return (da.date||'').localeCompare(db.date||'');
            if(mode==='date_desc') return (db.date||'').localeCompare(da.date||'');
            if(mode==='size_desc') return (parseInt(db.fileSize||0,10)-parseInt(da.fileSize||0,10));
            if(mode==='type_asc') return (da.fileType||'').localeCompare(db.fileType||'','ru');
            var orderDiff = (parseInt(da.order||999999,10)-parseInt(db.order||999999,10));
            if(orderDiff!==0) return orderDiff;
            var dateDiff = (db.date||'').localeCompare(da.date||'');
            if(dateDiff!==0) return dateDiff;
            return (da.title||'').localeCompare(db.title||'','ru');
        }
        function sortItems(){
            var mode = $sort.val() || 'manual';
            var $tableBody = $library.find('.wdl-document-table tbody');
            var rows = $tableBody.find('.wdl-document-item').get().sort(function(a,b){ return compareItems(a,b,mode); });
            rows.forEach(function(el){ $tableBody.append(el); });
            var $grid = $library.find('.wdl-cards');
            var cards = $grid.find('.wdl-document-item').get().sort(function(a,b){ return compareItems(a,b,mode); });
            cards.forEach(function(el){ $grid.append(el); });
        }

        function switchView(view){
            $containers.removeClass('is-active').filter('[data-view="'+view+'"]').addClass('is-active');
            $buttons.removeClass('is-active').filter('[data-view="'+view+'"]').addClass('is-active');
        }

        function filterItems(){
            var query = (($search.val() || '') + '').toLowerCase().trim();
            var matched = 0;
            $library.find('[data-wdl-item]').each(function(){
                var $item = $(this);
                var title = ($item.data('title') || '').toString().toLowerCase();
                var summary = ($item.data('summary') || '').toString().toLowerCase();
                var visible = !query || title.indexOf(query) !== -1 || summary.indexOf(query) !== -1;
                $item.toggle(visible);
                if(visible){ matched++; }
            });
            $noResults.prop('hidden', matched !== 0);
        }

        $buttons.on('click', function(){
            var v=$(this).data('view');
            switchView(v);
            try{ localStorage.setItem(storageKey,v); }catch(e){}
        });
        $search.on('input', filterItems);
        $sort.on('change', function(){ sortItems(); filterItems(); });

        switchView(initialView);
        sortItems();
        filterItems();
    });

    $('.wdl-document-viewer-section').each(function(){
        var $section = $(this), $toggle = $section.find('.wdl-viewer-toggle').first(), $wrap = $section.find('.wdl-document-viewer-wrap').first();
        if(!$toggle.length || !$wrap.length){ return; }
        $toggle.on('click', function(){
            var isOpen = $toggle.attr('aria-expanded') === 'true', nextOpen = !isOpen;
            $toggle.attr('aria-expanded', nextOpen ? 'true' : 'false');
            $toggle.text(nextOpen ? ($toggle.data('text-close') || 'Скрыть документ') : ($toggle.data('text-open') || 'Посмотреть документ'));
            $wrap.prop('hidden', !nextOpen);
        });
    });

});
