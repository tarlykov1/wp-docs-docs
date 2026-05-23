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

        switchView(initialView);
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
