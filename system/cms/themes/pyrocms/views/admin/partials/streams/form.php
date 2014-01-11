<?php if ($fields): ?>

<?php echo form_open_multipart($form_url, 'class="streams_form"'); ?>

<!-- .panel-body -->
<div class="panel-body">

	<?php foreach ($fields as $field): ?>

		<div class="form-group <?php  echo in_array($field['input_slug'], $hidden) ? 'hidden' : null;  ?>">
			<label for="<?php echo $field['input_slug'];?>">
				<?php echo lang_label($field['input_title']);?> <?php echo $field['required'];?>
			</label>

			<?php echo $field['input']; ?>

			<?php if( $field['instructions'] != '' ): ?>
				<p class="help-block"><?php echo lang_label($field['instructions']); ?></p>
			<?php endif; ?>
		</div>

	<?php endforeach; ?>

</div>
<!-- /.panel-body -->


<?php if ($mode == 'edit') { ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

<div class="panel-footer">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
</div>

<?php echo form_close();?>


<?php else: ?>


<div class="no_data">
<?php

	if (isset($no_fields_message) and $no_fields_message) {
		echo lang_label($no_fields_message);
	} else {
		echo lang('streams:no_fields_msg_first');
	}

?>
</div>

<?php endif; ?>