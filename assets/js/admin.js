jQuery(function($){
    var frame;
    $('#wdl-select-file').on('click',function(e){
        e.preventDefault();
        var f=wp.media({title:'Выберите файл',button:{text:'Использовать файл'},multiple:false});
        f.on('select',function(){ var a=f.state().get('selection').first().toJSON(); $('#wdl_file_id').val(a.id); $('#wdl_file_url').val(a.url); });
        f.open();
    });
    $('#wdl-remove-file').on('click',function(e){ e.preventDefault(); $('#wdl_file_id').val(''); $('#wdl_file_url').val(''); });

    $('#wdl-select-default-thumbnail').on('click', function(e){
        e.preventDefault();
        if(frame){ frame.open(); return; }
        frame = wp.media({title:'Выберите миниатюру по умолчанию',button:{text:'Использовать изображение'},multiple:false});
        frame.on('select', function(){
            var a = frame.state().get('selection').first().toJSON();
            $('#wdl-default-thumbnail-id').val(a.id);
            var src = a.sizes && a.sizes.medium ? a.sizes.medium.url : a.url;
            $('#wdl-default-thumbnail-preview').html('<img src="'+src+'" style="max-width:220px;height:auto;" />');
        });
        frame.open();
    });
    $('#wdl-remove-default-thumbnail').on('click', function(e){ e.preventDefault(); $('#wdl-default-thumbnail-id').val(''); $('#wdl-default-thumbnail-preview').empty(); });
});
