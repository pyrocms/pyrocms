<?php echo form_open_multipart(uri_string(), 'class="streams_form"'); ?>

<div class="form_inputs">

	<ul>

	<?php foreach( $fields as $field ) { ?>

		<li>
			<label for="<?php echo $field['input_slug'];?>"><?php echo $field['input_title'];?> <?php echo $field['required'];?>
			
			<?php if( $field['instructions'] != '' ): ?>
				<br /><small><?php echo $field['instructions']; ?></small>
			<?php endif; ?>
			</label>
			
			<div class="input"><?php echo $field['input']; ?></div>
		</li>

	<?php } ?>
	
	</ul>	

</div>

	<?php if ($mode == 'edit'){ ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

	<div class="float-right buttons">
		<button type="submit" name="btnAction" value="save" class="btn blue"><span><?php echo lang('buttons.save'); ?></span></button>	
		<a href="<?php echo site_url('admin/streams/entries/index/'.$stream->id); ?>" class="btn gray"><?php echo lang('buttons.cancel'); ?></a>
	</div>

<?php echo form_close();?>	
