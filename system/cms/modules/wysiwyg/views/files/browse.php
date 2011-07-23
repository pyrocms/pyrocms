<script type="text/javascript">
var CKEDITOR = window.parent.CKEDITOR;

function insertFile(id, title)
{
	if(replace_html)
	{
		replace_html.remove();
	}
	window.parent.instance.insertHtml('<a class="pyro-file" href="' + SITE_URL + 'files/download/' + id + '">' + title + '</a>');
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

				// Have they clicked inside an <a> tag?
				maybe_element = range.getCommonAncestor().getAscendant( 'a', true );

				if(!maybe_element) return false;
				else element = jQuery(maybe_element.$);

				// Save this HTML to be replaced up update
				replace_html = maybe_element;
			}

			if( ! element.hasClass('pyro-file')) return false;

			$('#current_document').load(SITE_URL + 'admin/wysiwyg/files/ajax_get_file', {
				doc_id: element.attr('href').match(/\/download\/([0-9]+)/)[1]
			});

			return true;
		}
		$('#images-container tr:odd').addClass('even');
		detectFile() || $('#current_document h2').hide();
	});
})(jQuery);
</script>

<?php if (!empty($folders)): ?>
<div id="folder-container">
<h3>Available Folders</h3>
<ul>
	<?php foreach ($folders as $folder): ?>
	<li class="folder">
		<p class="name"><?php echo anchor('admin/wysiwyg/files/browse/'.$folder->id, $folder->name); ?></p>
		<p class="image">
			<?php echo anchor('admin/wysiwyg/files/browse/'.$folder->id,
			'<img src="'.base_url().'system/cms/assets/img/icons/folder_open.png" alt="" />'); ?>
		</p>
	</li>
	
	<?php endforeach; ?>
</ul>
</div>

<?php endif;?>
<div id="images-container">
<?php if (!empty($folder_meta)): ?>
<h3>Files in "<?php echo $folder_meta->name; ?>"
<span><?php echo anchor('admin/wysiwyg/files', 'Go Back'); ?></span><br />
<span><?php echo anchor('admin/files/upload/'.$folder_meta->id, 'Upload', 'class="iframe" rel="modal"'); ?></span>
</h3>
<?php endif; ?>
<?php if (!empty($files)): ?>

	<table width="100%" border="0" class="table-list" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th width="50%"><strong>Title</strong></th>
				<th width="30%"><strong>File Type</strong></th>
				<th width="20%" />
			</tr>
		</thead>
		<tbody>

            <?php foreach ($files as $file): ?>

				<tr class="file">
					<td>&nbsp;&nbsp;<?php echo $file->name; ?></td>
					<td><?php echo strtoupper($file->extension); ?></td>
					<td class="buttons">
						<button onclick="javascript:insertFile('<?php echo $file->id; ?>', '<?php echo htmlentities($file->name); ?>');">
							Insert
						</button>
					</td>
				</tr>

			<?php endforeach; ?>
		</tbody>
	</table>

<?php elseif (empty($folders)): ?>
	<p>No files found.</p>
<?php endif;?>
	<p id="create_folder"><?php echo anchor('admin/files/folders/create', 'Create Folder', 'class="iframe" rel="modal"'); ?></p>
</div>
