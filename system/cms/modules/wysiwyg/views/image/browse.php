<script type="text/javascript">
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

function get_align()
{
	img_align = jQuery('input[name=insert_align]:checked').val();
	
	if(img_align == 'none')
	{
		return '';
	}
	
	if(img_align == 'left' || img_align == 'right')
	{
		return 'float: '+img_align+';';
	}
	
	if(img_align == "center")
	{
		return 'display: block; margin: 0 auto;';
	}
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
		
		$('#images-container img').hover( function() {
		    $(this).attr('title', 'Click to insert image');
		});
	});
})(jQuery);
</script>
<?php if (!empty($folders)): ?>
<div id="folder-container">
<h3>Available Folders</h3>
    <ul>
	    <?php foreach ($folders as $folder): ?>
	    <li class="folder">
		<p class="name"><?php echo anchor('admin/wysiwyg/image/browse/'.$folder->id, $folder->name); ?></p>
		<p class="image">
		    <?php echo anchor('admin/wysiwyg/image/browse/'.$folder->id,
		    '<img src="'.base_url().'system/cms/assets/img/icons/folder_open.png" alt="" />'); ?>
		</p>
	    </li>
	    <?php endforeach; ?>
    </ul>
</div>
<?php endif;?>
<div id="images-container">
<?php if (!empty($folder_meta)): ?>
<h3>Images in "<?php echo $folder_meta->name; ?>"
<span><?php echo anchor('admin/wysiwyg/image', 'Go Back'); ?></span><br />
<span><?php echo anchor('admin/files/upload/'.$folder_meta->id, 'Upload', 'class="iframe" rel="modal"'); ?></span>
</h3><?php endif; ?>
<?php if (!empty($files)): ?>
    
	<div class="defaults">
	    <p class="element">
		<label for="insert_width">Image Width:</label>
		<input id="insert_width" type="text" name="insert_width" value="200" />
	    </p>
	    <p class="element element-last">
		<label for="insert_float">Float:</label>
		<span>Left</span><input type="radio" name="insert_align" value="left" />
		<span>Right</span><input type="radio" name="insert_align" value="right" />
		<span>Center</span><input type="radio" name="insert_align" value="center" />
		<span>None</span><input type="radio" name="insert_align" value="none" checked="checked" />
	    </p>
	</div>
	<ul>
            <?php foreach ($files as $file): ?>

	    <li class="file">
		    <p class="name"><?php echo $file->name; ?></p>
		    <p class="type"><?php echo $file->mimetype; ?></p>
		    <p class="image">
			<img class="pyro-image" src="<?php echo base_url() . UPLOAD_PATH . 'files/' . $file->filename; ?>" alt="<?php echo $file->name; ?>" width="200" onclick="insertImage('<?php echo $file->filename; ?>', '<?php echo htmlentities($file->name); ?>');" />
		    </p>
		    
	    </li>

	    <?php endforeach; ?>
	</ul>

<?php elseif (empty($folders)): ?>
	<p>No files found.</p>
<?php endif;?>
<p id="create_folder"><?php echo anchor('admin/files/folders/create', 'Create Folder', 'class="iframe" rel="modal"'); ?></p>
</div>
