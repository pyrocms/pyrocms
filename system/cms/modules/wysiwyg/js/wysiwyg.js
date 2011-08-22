var CKEDITOR = window.parent.CKEDITOR;
var img_float;

function insertImage(file, alt)
{
	if(replace_html)
	{
		replace_html.remove();
	}
	var img_width = document.getElementById('insert_width').value;
	
	window.parent.instance.insertHtml('<img class="pyro-image" style="float: '+get_float()+';" src="' + BASE_URI + UPLOAD_PATH + 'files/' + file + '" alt="' + alt + '" width="'+img_width+'" />');
    windowClose();
}

function insertFile(id, title)
{
	if(replace_html)
	{
		replace_html.remove();
	}
	window.parent.instance.insertHtml('<a class="pyro-file" href="' + SITE_URL + 'files/download/' + id + '">' + title + '</a>');
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

			$('#current_document').load(SITE_URL + 'admin/wysiwyg/files/ajax_get_file', {
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
        $('select, #upload-box input[type=text], input[type=file], input[type=submit]').livequery(function() {
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
			
			//remove any notifications
			$( 'div.notification' ).fadeOut('fast');
            
			if ($(this).attr('title') != 'upload')
			{
				$('#files_right_pane').load(href_val + ' #files-wrapper', function() {
					$(this).children().fadeIn('slow');
				});
			}
			else
			{
				var box = $('#upload-box');
				if (box.is( ":visible" ))
				{
					// Hide - slide up.
					box.fadeOut( 800 );
				}
				else
				{
					// Show - slide down.
					box.fadeIn( 800 );
					 
				}
			}
        });
		
		$( '#upload-box span.close' ).live('click', function() {
			
			$( '#upload-box' ).fadeOut( 800, function() {
				$(this).find('input[type=text], input[type=file]').val('');
				$.uniform.update('input[type=file]');
			});
			
		});
        
        $('select[name=parent_id]').live('change', function() {
            var folder_id = $(this).val();
			var controller = $(this).attr('title');
            var href_val = SITE_URL + 'admin/wysiwyg/' + controller + '/index/' + folder_id;
            $('#files_right_pane').load(href_val + ' #files-wrapper', function() {
				$(this).children().fadeIn('slow');
				var class_exists = $('#folder-id-' + folder_id).html();
				$( 'div.notification' ).fadeOut('fast');
				if(class_exists !== null)
				{
					$('#files-nav li').removeClass('current');
					$('li#folder-id-'+folder_id).addClass('current'); 
				}
				  
            });
        })
        
        //slider
       
        $( "#slider" ).livequery(function() {
			$(this).fadeIn('slow');
			$(this).slider({
				value:200,
				min: 50,
				max: 800,
				step: 1,
				slide: function( event, ui ) {
					$( "#insert_width" ).val( ui.value + 'px' );
				}
			});
			$( "#insert_width" ).val( $( "#slider" ).slider( "value" ) + 'px' );
        });
        
		$('#radio-group').livequery(function(){
			$(this).children('.set').buttonset();
			$(this).fadeIn('slow');
		});

		$( '#files_right_pane' ).livequery(function() {
			$(this).children().fadeIn('slow');
			$('#upload-box').hide();
		});
		
//		$( 'td.image button, a.button').livequery(function() {
//			$(this).button();
//		});
		
	});
})(jQuery);