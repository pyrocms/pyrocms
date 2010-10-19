<script type="text/javascript">
var CKEsDITOR = window.parent.CKEDITOR;

function insertFile(id, title)
{
	if(replace_html)
	{
		replace_html.remove();
	}
	window.parent.instance.insertHtml('<a class="pyro-file" href="' + '<?php echo site_url(); ?>files/download/' + id + '">' + title + '</a>');
    windowClose();
}

// By default, insert (which will also replace)
var replace_html = null;

(function($)
{s
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

			if( ! element.hasClass('mizu-document')) return false;
			if( ! element.attr('href').match(/\/downloads\/document\/[0-9]+/)) return false;

			$('#current_document').load(BASE_URI + 'admin/wysiwyg/files/ajax_get_document', {
				doc_id: element.attr('href').match(/\/document\/([0-9]+)/)[1]
			});

			return true;
		}

		detectFile() || $('#current_document h2').hide();
	});
})(jQuery);
</script>

<ul class="breadcrumb">
    <li>
        <strong><?php echo anchor('cms/wysiwyg/document', '&raquo; Root'); ?></strong>
    </li>
    <?php foreach( $breadcrumbs as $crumb ): ?>
    <li>
        <?php echo anchor('cms/wysiwyg/document/browse/folder/' . $crumb->id, "&raquo; " . $crumb->title); ?>
    </li>
    <?php endforeach; ?>
    <div class="clear"></div>
</ul>

<br style="clear:both"/>

<?php if (!empty($files)): ?>

	<table width="100%" border="0" class="table-list">
		<thead>
			<tr>
				<th width="50%"><strong>Title</strong></th>
				<th width="10%"><strong>File Type</strong></th>
				<th width="20%"><strong>Status</strong></th>
				<th width="20%" />
			</tr>
		</thead>
		<tbody>

            <?php foreach ($files as $document): ?>

			<?php if($document->is_folder): ?>

				<tr class="folder">
					<td>&nbsp;&nbsp;<?php echo image('icons/black/16/folder_arrow.png'); ?><?php echo anchor('cms/wysiwyg/document/browse/' . $criteria_uri . 'folder/' . $document->id, $document->title); ?></td>
					<td><em>Folder</em></td>
					<td><?php echo lang('status.'.$document->status); ?>
					<td></td>
				</tr>

			<?php else: ?>

				<tr class="file">
					<td>&nbsp;&nbsp;<?php echo $document->title; ?></td>
					<td><?php echo strtoupper($document->ext); ?></td>
					<td><?php echo lang('status.'.$document->status); ?>
					<td class="buttons">
						<?php if($document->status == 'live'): ?>
							<button onclick="javascript:insertFile('<?php echo $document->id; ?>', '<?php echo htmlentities($document->title); ?>');">
								<?php echo image('icons/black/16/round_plus.png'); ?>Insert
							</button>
						<?php endif; ?>
					</td>
				</tr>

			<?php endif; ?>

			<?php endforeach; ?>
		</tbody>
	</table>

<?php else: ?>
	<p>No documents found.</p>
<?php endif;?>