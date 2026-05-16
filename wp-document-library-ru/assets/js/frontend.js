jQuery(function($){
    $('.wdl-categories-tree .wdl-category-item').on('click',function(){$(this).toggleClass('is-open');});

    $('.wdl-library').each(function(){
        var $library = $(this);
        var defaultView = $library.data('default-view') || 'table';
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

        $buttons.on('click', function(){ switchView($(this).data('view')); });
        $search.on('input', filterItems);

        switchView(defaultView);
    });
});
