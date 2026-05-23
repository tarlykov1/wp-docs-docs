jQuery(function($){
    $('.wdl-categories-tree .wdl-category-item').on('click',function(){$(this).toggleClass('is-open');});

    $('.wdl-library').each(function(){
        var $library = $(this);
        var defaultView = localStorage.getItem('wdl-view') || $library.data('default-view') || 'table';
        var $containers = $library.find('.wdl-view-container');
        var $buttons = $library.find('.wdl-toggle-button');
        var $search = $library.find('.wdl-search-input');
        var $noResults = $library.find('.wdl-no-results');

        function switchView(view){
            $containers.removeClass('is-active').filter('[data-view="'+view+'"]').addClass('is-active');
            $buttons.removeClass('is-active').filter('[data-view="'+view+'"]').addClass('is-active');
        }

        function filterItems(){
            var query = (($search.val() || '') + '').toLowerCase().trim();
            var matched = 0;
            $library.find('.wdl-item').each(function(){
                var haystack = ($(this).data('search') || '').toString();
                var visible = !query || haystack.indexOf(query) !== -1;
                $(this).toggle(visible);
                if(visible){ matched++; }
            });
            $noResults.prop('hidden', matched !== 0);
        }

        $buttons.on('click', function(){ var v=$(this).data('view'); switchView(v); try{localStorage.setItem('wdl-view',v);}catch(e){} });
        $search.on('input', filterItems);

        switchView(defaultView);
    });

    $('.wdl-document-viewer-section').each(function(){
        var $section = $(this);
        var $toggle = $section.find('.wdl-viewer-toggle').first();
        var $wrap = $section.find('.wdl-document-viewer-wrap').first();
        if(!$toggle.length || !$wrap.length){ return; }

        $toggle.on('click', function(){
            var isOpen = $toggle.attr('aria-expanded') === 'true';
            var nextOpen = !isOpen;
            $toggle.attr('aria-expanded', nextOpen ? 'true' : 'false');
            $toggle.text(nextOpen ? ($toggle.data('text-close') || 'Скрыть документ') : ($toggle.data('text-open') || 'Посмотреть документ'));
            $wrap.prop('hidden', !nextOpen);
        });
    });

});
