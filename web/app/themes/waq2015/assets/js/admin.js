jQuery(document).ready(function($){
    

    // CROP THUMBNAILS
    // Ajout de liens sur toutes les champs images acf

    var url = document.location.pathname;
    var position = url.indexOf('wp-admin/');
    var root = url.substr(0,position);

	var inputImages = $('input.acf-image-value');

    if(inputImages.length>0){
        $(inputImages).each(function(){
            var id = $(this).val();
            if(id){
                $(this).after('<a class="crop thickbox" href="'+root+'wp-admin/admin-ajax.php?action=croppostthumb_ajax&amp;image_id='+id+'&amp;viewmode=single&amp;TB_iframe=1&amp;width=800&amp;height=855" title="Crop Thumbnail">Recadrer</a>');                
            }
        }).change(function(){
            var id = $(this).val();
            $(this).siblings('a.crop').remove();
            if(id){
                $(this).after('<a class="crop thickbox" href="'+root+'wp-admin/admin-ajax.php?action=croppostthumb_ajax&amp;image_id='+id+'&amp;viewmode=single&amp;TB_iframe=1&amp;width=800&amp;height=855" title="Crop Thumbnail">Recadrer</a>');                
            }
        });
    }
})