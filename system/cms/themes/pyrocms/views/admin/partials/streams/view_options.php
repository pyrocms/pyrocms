<div class="content">

<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="form_inputs">

	<ul>

		<li>
			<label for="stream_name"><?php echo lang('streams:id');?></label>
			<div class="input"><input type="checkbox" name="view_options[]" id="stream_name" value="id"<?php if(in_array('id', $stream->view_options)): echo ' checked '; endif; ?>/></div>
		</li>

		<li>
			<label for="created"><?php echo lang('streams:created_date');?></label>
			<div class="input"><input type="checkbox" name="view_options[]" id="created" value="created"<?php if(in_array('created', $stream->view_options)): echo ' checked '; endif; ?>/></div>
		</li>

		<li>
			<label for="updated"><?php echo lang('streams:updated_date');?></label>
			<div class="input"><input type="checkbox" name="view_options[]" id="updated" value="updated"<?php if(in_array('updated', $stream->view_options)): echo ' checked '; endif; ?>/></div>
		</li>

		<li>
			<label for="created_by"><?php echo lang('streams:created_by');?></label>
			<div class="input"><input type="checkbox" name="view_options[]" id="created_by" value="created_by"<?php if(in_array('created_by', $stream->view_options)): echo ' checked '; endif; ?>/></div>
		</li>
		
	<?php if( $stream_fields ): ?>
	
	<?php foreach( $stream_fields as $stream_field ): ?>

		<li>
			<label for="<?php echo $stream_field->field_slug;?>"><?php echo $stream_field->field_name;?></label>
			<div class="input"><input type="checkbox" name="view_options[]" id="<?php echo $stream_field->field_slug;?>" value="<?php echo $stream_field->field_slug;?>"<?php if(in_array($stream_field->field_slug, $stream->view_options)): echo ' checked '; endif; ?>/></div>
		</li>
		
	<?php endforeach; ?>
	
	<?php endif; ?>
	
	</ul>
					
</div>

		<button type="submit" name="btnAction" value="save" class="btn blue"><span><?php echo lang('buttons:save'); ?></span></button>	
		<a href="<?php echo site_url($return); ?>" class="btn gray"><?php echo lang('buttons:cancel'); ?></a>
<?php echo form_close();?>

</div>