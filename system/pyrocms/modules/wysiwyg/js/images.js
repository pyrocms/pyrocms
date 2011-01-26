var CKEDITOR = window.parent.CKEDITOR;
var img_float;
function insertImage(file, alt)
{
	if(replace_html)
	{
		replace_html.remove();
	}
	var img_width = document.getElementById('insert_width').value;
	
	window.parent.instance.insertHtml('<img class="pyro-image" style="float: '+get_float()+';" src="uploads/files/' + file + '" alt="' + alt + '" width="'+img_width+'" />');
    windowClose();
}

function get_float()
{
    img_float = jQuery('input[name=insert_float]:checked').val();
    return img_float;
}

// By default, insert (which will also replace)
var replace_html = null;

(function($)
{
	$(function()
	{
		function detectFile()
		{
			// Get whatever is selected
			selection = window.parent.instance.getSelection();

			// A Tag has been fuly selected
			if(selection.getSelectedElement())
			{
				element = jQuery( selection.getSelectedElement().$ );
			}

			// If the cursor is anywhere in the textbox
			else(selection.getRanges()[ 0 ])
			{
				// Find the range of the selection
				range = selection.getRanges()[ 0 ];
				range.shrink( CKEDITOR.SHRINK_TEXT );

				// Have they clicked inside an <img> tag?
				maybe_element = range.getCommonAncestor().getAscendant( 'img', true );

				if(!maybe_element) return false;
				else element = jQuery(maybe_element.$);

				// Save this HTML to be replaced up update
				replace_html = maybe_element;
			}

			if( ! element.hasClass('pyro-image')) return false;

			$('#current_document').load(BASE_URI + 'admin/wysiwyg/files/ajax_get_file', {
				doc_id: element.attr('href').match(/\/download\/([0-9]+)/)[1]
			});

			return true;
		}

		detectFile() || $('#current_document h2').hide();
		
        //tooltip
		$('#images-container img').hover( function() {
		    $(this).attr('title', 'Click to insert image');
		});
        
        //cue up uniform
        $('select[name=parent_id]').livequery(function() {
            $.uniform && $(this).uniform(); 
        });
        
        /**
         * left files navigation handler
         *  - handles loading of different folders
         *  - manipulates dom classes etc
         */
        $('#files-nav li a').live('click', function(e) {
            
            e.preventDefault();
            
            var href_val = $(this).attr('href');
            
            //remove existing 'current' classes
            $('#files-nav li').removeClass('current');
            
            //add class to click anchor parent
            $(this).parent('li').addClass('current');
            
            $('#files_right_pane').load(href_val + ' #files_right_pane');
            
        });
        
        $('select[name=parent_id]').live('change', function() {
            var folder_id = $(this).val();
            var href_val = 'image/index/' + folder_id;
            $('#files_right_pane').load(href_val + ' #files_right_pane', function() {
                $('#files-nav li').removeClass('current');
                $('li#folder-id-'+folder_id).addClass('current');   
            });
        })
        
        //slider
       
        $( "#slider" ).slider({
            value:200,
            min: 200,
            max: 800,
            step: 50,
            slide: function( event, ui ) {
                $( "#insert_width" ).val( ui.value + 'px' );
            }
        });
        $( "#insert_width" ).val( $( "#slider" ).slider( "value" ) + 'px' );
    
        $('#radio-group').buttonset();

        
	});
})(jQuery);