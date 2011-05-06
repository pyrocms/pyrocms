<script type="text/javascript">
var CKEDITOR = window.parent.CKEDITOR;

function insertImage()
{
	source = jQuery('input[name="source"]').val();
	width = jQuery('input[name="width"]').val();
	height = jQuery('input[name="height"]').val();
	alt = jQuery('input[name="alt"]').val();
	align = jQuery('select[name="align"]').val();

    var html = '<img class="mizu-image" width="'+width+'" height="'+height+'" src="'+ source +'" alt="'+ alt +'" align="'+align+'" />';

	window.parent.instance.insertHtml(html);

    windowClose();
}

function doPreview()
{
	// Update preview image
	jQuery("preview").css({
		width: jQuery('input[name="width"]').val(),
		height: jQuery('input[name="height"]').val()
	}).attr({
		alt: jQuery('input[name="alt"]').val(),
		align: jQuery('select[name="align"]').val()
	})
}

// By default, insert (which will also replace)
var replace_html = null;

(function($)
{
	$(function()
	{
		function detectImage()
		{
			if(!window.parent.instance) return false;

			// Get whatever is selected
			selection = window.parent.instance.getSelection();

			// A Tag has been fuly selected
			if(!selection.getSelectedElement()) return false;

			element = jQuery( selection.getSelectedElement().$ );

			if( ! element.hasClass('mizu-image')) return false;
			if( ! element.attr('src').match(/uploads\/[0-9]+\/images\/[0-9a-z]+/i)) return false;

			source = element.attr('src');
			width = element.attr('width');
			height = element.attr('height');
			alt = element.attr('alt');
			align = element.attr('align');
			$('a#preview').attr('href', source).show();

			// Get the unique hash from the filename
			filename = source.match(/([a-z0-9]+\.[a-z]{3,5})$/i)[1];

			$.post(SITE_URL + 'cms/wysiwyg/image/ajax_get_image', { filename: filename }, function(data){

				$('#current_image').html(data.output);
				$('#display-source').html(filename + "&nbsp;&nbsp;&nbsp;&nbsp;");

				$('input[name="source"]').val( source );
				$('input[name="width"]').val( width );
				$('input[name="height"]').val( height );
				$('input[name="alt"]').val( alt );
				$('input[name="align"]').val( align );

				$('#browse-link').attr('href', $('#browse-link').attr('href') + '/folder/' + data.folder_id);
			}, 'json');

			return true;
		}

		if(<?php echo (int) empty($title); ?> && !detectImage())
		{
			$('#current_image h4').hide();
		}

		$('a#preview[href="#"]').hide();
	});
})(jQuery);
</script>

<div id="current_image">
    <?php if(isset($title)): ?>
        <?php $this->load->view('image/ajax_current'); ?>
    <?php else: ?>
        <h4>Title: Getting title...</h4>
    <?php endif; ?>
</div>

<ul class="crud">
    <li>
        <label>Source:</label>
        <input type="hidden" name="source" value="<?php echo @$source; ?>">
        <span id="display-source"><?php echo @$source ? basename($source) . "&nbsp;&nbsp;&nbsp;&nbsp;" : ''; ?></span>
        <?php echo anchor('cms/wysiwyg/image/browse' . (!empty($folder_id) ? '/folder/' . $folder_id : ''), 'Browse &raquo;', 'id="browse-link"'); ?>
        <div class="clear"></div>
    </li>

    <li>
        <label>Alt Tag:</label>
        <input type="text" name="alt" value="<?php echo @$title; ?>" onkeyup="doPreview()">
    </li>

    <li>
        <label>Alignment</label>
       <select id="align" name="align" style="width:150px" class="inpSel" onchange="doPreview()">
            <option value="" selected>None</option>
            <option value="left" id="optLang" name="optLang">Left</option>
            <option value="right" id="optLang" name="optLang">Right</option>
            <option value="top" id="optLang" name="optLang">Top</option>
            <option value="textTop" id="optLang" name="optLang">Text Top</option>
            <option value="bottom" id="optLang" name="optLang">Bottom</option>
            <option value="absBottom" id="optLang" name="optLang">Absolute Bottom</option>
            <option value="middle" id="optLang" name="optLang">Middle</option>
            <option value="absMiddle" id="optLang" name="optLang">Absolute Middle</option>
            <option value="baseline" id="optLang" name="optLang">Baseline</option>
        </select>
    </li>

    <li>
        <label>Width / Height:</label>
        <input type="text" name="width" size=2 value="<?php echo @$width; ?>" style="width:100px">&nbsp;px&nbsp;&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;
        <input type="text" name="height" size=2 value="<?php echo @$height; ?>" style="width:100px">&nbsp;px&nbsp;&nbsp;&nbsp;&nbsp;
    </li>

</ul>

<div class="buttons label-offset">
    <button type="submit" name="save" value="" class="positive" onclick="insertImage()"><?php echo image('icons/black/16/round_plus.png'); ?>Insert</button>
    <a href="#" class="negative" onclick="windowClose()"><?php echo image('icons/white/16/round_delete.png'); ?><?php echo lang('button.cancel');?></a>
</div>