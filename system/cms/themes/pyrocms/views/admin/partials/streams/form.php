<?php if ($fields): ?>

<?php echo form_open_multipart(uri_string(), 'class="streams_form"'); ?>

<fieldset class="padding-top">
	<ul>

	<?php foreach ($fields as $field ): ?>

		<li class="row-fluid input-row <?php echo in_array($field['input_slug'], $hidden) ? 'hidden' : null; ?>">
			<label class="span3" for="<?php echo $field['input_slug'];?>"><?php echo $this->fields->translate_label($field['input_title']);?> <?php echo $field['required'];?>
			
			<?php if( $field['instructions'] != '' ): ?>
				<small><?php echo $this->fields->translate_label($field['instructions']); ?></small>
			<?php endif; ?>
			</label>
			
			<div class="input span9"><?php echo $field['input']; ?></div>
		</li>

	<?php endforeach; ?>

	</ul>
</fieldset>

<?php if ($mode == 'edit'){ ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

<div class="btn-group padded no-padding-bottom">
	<button type="submit" name="btnAction" value="save" class="btn"><span><?php echo lang('buttons:save'); ?></span></button>
	<?php if (isset($cancel_uri)): ?>
		<a href="<?php echo site_url($cancel_uri); ?>" class="btn"><?php echo lang('buttons:cancel'); ?></a>
	<?php else: ?>
		<a href="<?php echo site_url(isset($return) ? $return : 'admin/streams/entries/index/'.$stream->id); ?>" class="btn"><?php echo lang('buttons:cancel'); ?></a>
	<?php endif; ?>
</div>

<?php echo form_close();?>

<?php else: ?>

<div class="alert margin">
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