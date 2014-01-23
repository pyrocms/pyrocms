<?php if ($fields): ?>


<?php if (!$disableFormOpen): ?>
<?php echo form_open_multipart($formUrl, 'class="streams_form"'); ?>
<?php endif; ?>


<!-- .panel-body -->
<div class="panel-body">

	<?php foreach ($fields as $field): ?>

		<div class="form-group <?php  echo in_array(str_replace($stream->stream_namespace.'-'.$stream->stream_slug.'-', '', $field->input_slug), $hidden) ? 'hidden' : null;  ?>">
		<div class="row">
			
			<?php echo $field->input_row; ?>

		</div>
		</div>

	<?php endforeach; ?>

</div>
<!-- /.panel-body -->

<?php if ($mode == 'edit') { ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

<?php if (!$disableFormOpen): ?>
<div class="panel-footer">
	<button type="submit" name="btnAction" value="save" class="btn btn-success"><?php echo lang('buttons:save'); ?></button>
	
	<?php if (! empty($exitRedirect)): ?>
	<button type="submit" name="btnAction" value="save_exit" class="btn btn-success"><?php echo lang('buttons:save_exit'); ?></button>
	<?php endif; ?>

	<?php if (! empty($createRedirect)): ?>
	<button type="submit" name="btnAction" value="save_create" class="btn btn-info"><?php echo lang('buttons:save_create'); ?></button>
	<?php endif; ?>

	<?php if (! empty($continueRedirect)): ?>
	<button type="submit" name="btnAction" value="save_continue" class="btn btn-info"><?php echo lang('buttons:save_continue'); ?></button>
	<?php endif; ?>

	<a href="<?php echo site_url(isset($uriCancel) ? $uriCancel : 'admin/streams/entries/index/'.$stream->id); ?>" class="btn btn-default"><?php echo lang('buttons:cancel'); ?></a>		
</div>
<?php endif; ?>


<?php if (isset($disableFormOpen) and ! $disableFormOpen): echo form_close(); endif; ?>

<?php else: ?>


<div class="alert alert-info m">

<?php

	if (isset($noFieldsMessage) and $noFieldsMessage) {
        echo lang_label($noFieldsMessage);
    } else {
        echo lang('streams:no_fields_msg_first');
    }
?>
</div>

<?php endif; ?>
