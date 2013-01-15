<?php if ($fields): ?>

<?php echo form_open_multipart(uri_string(), 'class="streams_form"'); ?>

<div class="form_inputs">

	<ul>

	<?php foreach ($fields as $field ) { ?>

		<li class="<?php echo in_array($field['input_slug'], $hidden) ? 'hidden' : null; ?>">
			<label for="<?php echo $field['input_slug'];?>"><?php echo $this->fields->translate_label($field['input_title']);?> <?php echo $field['required'];?>
			
			<?php if( $field['instructions'] != '' ): ?>
				<br /><small><?php echo $this->fields->translate_label($field['instructions']); ?></small>
			<?php endif; ?>
			</label>
			
			<div class="input"><?php echo $field['input']; ?></div>
		</li>

	<?php } ?>
	
	</ul>	

</div>

	<?php if ($mode == 'edit'){ ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

	<div class="float-right buttons">
		<button type="submit" name="btnAction" value="save" class="btn blue"><span><?php echo lang('buttons:save'); ?></span></button>	
		<a href="<?php echo site_url(isset($return) ? $return : 'admin/streams/entries/index/'.$stream->id); ?>" class="btn gray"><?php echo lang('buttons:cancel'); ?></a>
	</div>

<?php echo form_close();?>

<?php else: ?>

<div class="no_data">
	<?php
		
		if (isset($no_fields_message) and $no_fields_message)
		{
			echo lang_label($no_fields_message);
		}
		else
		{
			echo lang('streams:no_fields_msg_first');
		}

	?>
</div><!--.no_data-->

<?php endif; ?>