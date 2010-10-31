<script type="text/javascript">
var CKEDITOR = window.parent.CKEDITOR;

function insertImage(file, alt)
{
	if(replace_html)
	{
		replace_html.remove();
	}
	window.parent.instance.insertHtml('<img class="pyro-image" src="<?php echo base_url(); ?>uploads/files/' + file + '" alt="' + alt + '" />');
    windowClose();
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
	});
})(jQuery);
</script>
<?php if (!empty($folders)): ?>

<ul>
	<?php foreach ($folders as $folder): ?>
	<li><?php echo anchor('admin/wysiwyg/image/browse/'.$folder->id, $folder->name); ?>
	<?php endforeach; ?>
</ul>

<?php endif;?>
	
<?php if (!empty($files)): ?>

	<ul>
            <?php foreach ($files as $file): ?>

	    <li class="file">
		    <p class="name"><?php echo $file->name; ?></p>
		    <p class="type"><?php echo $file->mimetype; ?></p>
		    <p class="image">
			<img class="pyro-image" src="<?php echo base_url(); ?>uploads/files/<?php echo $file->filename; ?>" alt="<?php echo $file->name; ?>" width="200" /></p>
		    <p class="buttons">
			    <button onclick="javascript:insertImage('<?php echo $file->filename; ?>', '<?php echo htmlentities($file->name); ?>');">
				    Insert
			    </button>
		    </p>
	    </li>

	    <?php endforeach; ?>
	</ul>

<?php elseif (empty($folders)): ?>
	<p>No files found.</p>
<?php endif;?>