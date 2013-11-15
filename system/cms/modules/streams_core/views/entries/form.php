<?php if ($fields): ?>


<?php if (!$form_override): ?>
<?php echo form_open_multipart($form_url, 'class="streams_form"'); ?>
<?php endif; ?>


<!-- .panel-body -->
<div class="panel-body">

	<?php foreach ($fields as $field): ?>

		<div class="form-group <?php  echo in_array(str_replace($stream->stream_namespace.'-'.$stream->stream_slug.'-', '', $field['input_slug']), $hidden) ? 'hidden' : null;  ?>">
		<div class="row">
			
			<label class="col-lg-2" for="<?php echo $field['input_slug'];?>">
				<?php echo lang_label($field['input_title']);?> <?php echo $field['required'];?>

				<?php if( $field['instructions'] != '' ): ?>
					<p class="help-block"><?php echo lang_label($field['instructions']); ?></p>
				<?php endif; ?>

			</label>

			<div class="col-lg-10">
				<?php echo $field['input']; ?>
			</div>

		</div>
		</div>

	<?php endforeach; ?>

</div>
<!-- /.panel-body -->


<?php if ($mode == 'edit') { ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>


<?php if (!$form_override): ?>
<div class="panel-footer">
	<button type="submit" name="btnAction" value="save" class="btn btn-success"><?php echo lang('buttons:save'); ?></button>
	
	<?php if (! empty($exit_redirect)): ?>
	<button type="submit" name="btnAction" value="save_exit" class="btn btn-success"><?php echo lang('buttons:save_exit'); ?></button>
	<?php endif; ?>

	<?php if (! empty($create_redirect)): ?>
	<button type="submit" name="btnAction" value="save_create" class="btn btn-info"><?php echo lang('buttons:save_create'); ?></button>
	<?php endif; ?>

	<?php if (! empty($continue_redirect)): ?>
	<button type="submit" name="btnAction" value="save_continue" class="btn btn-success"><?php echo lang('buttons:save_continue'); ?></button>
	<?php endif; ?>

	<a href="<?php echo site_url(isset($cancel_uri) ? $cancel_uri : 'admin/streams/entries/index/'.$stream->id); ?>" class="btn btn-default"><?php echo lang('buttons:cancel'); ?></a>		
</div>
<?php endif; ?>


<?php if (!$form_override): ?>
<?php echo form_close();?>
<?php endif; ?>


<?php else: ?>


<div class="alert alert-info m">
<?php

	if (isset($no_fields_message) and $no_fields_message) {
		echo lang_label($no_fields_message);
	} else {
		echo lang('streams:no_fields_msg_first');
	}

?>
</div>

<?php endif; ?>