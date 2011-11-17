<li class="page-chunk">
	<div class="float-left">
<?php echo form_dropdown('chunk_type['.$id.']', array(
	'html' => 'html',
	'markdown' => 'markdown',
	'wysiwyg-simple' => 'wysiwyg-simple',
	'wysiwyg-advanced' => 'wysiwyg-advanced',
), $type); ?>&nbsp;
		<input type="text" name="chunk_slug[<?php echo $id ?>]" value="<?php echo $slug ?>">
		<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		<a class="btn red remove-chunk" href="javascript:void(0)" style="margin-left: 200px;" class="remove-chunk"><?php echo lang('global:remove') ?></a>
	</div>
	<br style="clear:both" />
	<textarea id="chunk=<?php echo $id ?>" name="chunk_body[<?php echo $id ?>]" rows="20" class="<?php echo $type ?>"><?php echo $body ?></textarea>
</li>
<br style="clear:both" />
