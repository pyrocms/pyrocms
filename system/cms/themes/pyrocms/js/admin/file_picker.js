jQuery(function($){

    $('#folders-sidebar li.folder').on('click',function(e){
        e.preventDefault();
        if ( !$(this).hasClass('current') ) {
            if ( ! $(this).hasClass('open') ) {
                $(this).removeClass('close');
                $(this).addClass('open');
            }
            ajax_folder_contents( $(this).attr('data-id') );
        } else {
            if ( $(this).hasClass('open') ) {
                $(this).removeClass('open');
                $(this).addClass('close');
                $(this).find('li.open').removeClass('open').addClass('close');
            } else {
                $(this).removeClass('close');
                $(this).addClass('open');
            }
        }
        return false;
    });

    $('#folders-sidebar li.folder > div, #folders-sidebar li.folder > a').on('click',function(e){
        e.preventDefault();
        $(this).parent().trigger('click');
        return false;
    });

    $('.file-picker-link').colorbox({inline:true, innerWidth:670, innerHeight:525, onLoad: function() {
        $('#cboxClose').remove();
    }, onCleanup:function(){
        ajax_folder_contents( 0 );
        $('#folders-sidebar li.folder').removeClass('current').removeClass('open').removeClass('close');
    }});

    $('.file-picker-close-button').live('click',function(e){
        e.preventDefault();
        $.colorbox.close();
    })

    $('.file-picker-apply-button').on('click',function(e){
        e.preventDefault();
        var field_id = $('#cboxLoadedContent div.file-picker-modal').attr('data-id');
        var is_multiple_selector = $('#cboxLoadedContent div.file-picker-modal').attr('is-multiple')==='true'?true:false;
        var file_container = $('#file-picker-container_'+field_id+' ul.selected-files-container');
        $('#cboxLoadedContent div.file-picker-modal div.right-side').find('input.file-selector:checked').map(function(){
            if ( is_multiple_selector ) {
                if ( $('li[data-id='+$(this).attr('data-id')+']', file_container).length == 0 ) {
                    file_container.append('<li data-id="'+$(this).attr('data-id')+'"><span>'+$(this).attr('data-name')+'</span><input type="hidden" value="'+$(this).attr('data-id')+'" name="'+field_id+'[]"/><a href="javascript:" class="unselected-button"><span>x</span></a></li>');
                }
            } else {
                file_container.html('<li data-id="'+$(this).attr('data-id')+'"><span>'+$(this).attr('data-name')+'</span><input type="hidden" value="'+$(this).attr('data-id')+'" name="'+field_id+'"/><a href="javascript:" class="unselected-button"><span>x</span></a></li>');
            }
        });

    })

    $('a.unselected-button').live('click',function(e){
        e.preventDefault();
        $(this).parent().remove();
        return false;
    })

});

function ajax_folder_contents( folder_id ) {
    var post_data = { parent : folder_id }
    $.post(SITE_URL + 'admin/files/folder_contents', post_data, function(data){
        var results = $.parseJSON(data);

        if (results.status) {

            var field_id = $('#cboxLoadedContent div.file-picker-modal').attr('data-id');
            var file_container = $('#file-picker-container_'+field_id+' ul.selected-files-container');

            var $folders_center = $('.folders-center');

            // so let's wipe it clean...
            $('.folders-center ').find('li').fadeOut('fast').remove();

            // iterate over array('folder' => $folders, 'file' => $files)
            $.each(results.data, function(type, data){

                $.each(data, function(index, item){

                    // if it's an image then we set the thumbnail as the content
                    var li_content = '<span class="name-text">'+item.name+'</span>';

                    var is_selected = $('li[data-id='+item.id+']', file_container).length > 0;

                    if ( type === 'file' ) {
                        if ( is_selected ) {
                            li_content = '<div class="selected-icon"> </div></div><input class="file-selector" type="checkbox" data-name="'+item.name+'" data-id="'+item.id+'" value="'+item.id+'" name="file_picker[]" />' + li_content;
                        } else {
                            li_content = '<div class="selected-icon"> </div></div><input class="file-selector" type="checkbox" data-name="'+item.name+'" data-id="'+item.id+'" value="'+item.id+'" name="file_picker[]" />' + li_content;
                        }
                    }

                    if (item.type && item.type === 'i') {
                        li_content = '<img src="'+SITE_URL+'files/cloud_thumb/'+item.id+'" alt="'+item.name+'"/>'+li_content;
                    }

                    $folders_center.append(
                        '<li class="'+type+' '+(type === 'file' ? 'type-'+item.type : '')+(is_selected?' selected':'')+'" data-id="'+item.id+'" data-name="'+item.name+'">'+
                            li_content+
                            '</li>'
                    );

                })

            });

            $('li.folder', $folders_center).bind('dblclick',function(e){
                e.preventDefault();
                var folder_id = $(this).attr('data-id');
                $('ul#folders-sidebar li[data-id="'+folder_id+'"]').trigger('click');
                return false;
            })

            $('li.file', $folders_center).bind('click',function(e){
                var is_multiple = $(this).parents('div.file-picker-modal').attr('is-multiple');
                if ( $(this).hasClass("selected") ) {
                    $(this).removeClass('selected');
                    $(this).find('input[type=checkbox]').removeAttr('checked');
                } else {
                    if ( is_multiple === 'false') {
                        $(this).parent().find('li.file.selected').removeClass('selected');
                        $(this).parent().find('input[type=checkbox]').removeAttr('checked');
                    }
                    $(this).addClass('selected');
                    $(this).find('input[type=checkbox]').attr('checked', 'checked');
                }
            });

            // add the current indicator to the correct folder
            $('ul#folders-sidebar').find('li').removeClass('current');
            $('ul#folders-sidebar [data-id="'+folder_id+'"]').not('.places').addClass('current');

        }
    });

}