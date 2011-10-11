<ol>
	<li class="even">
		<label>Address</label>
		<?php echo form_input('address', $options['address']); ?>
	</li>
	<li class="odd">
		<label>Width</label>
		<?php echo form_input('width', ($options['width'] != '' ? $options['width'] : '100%')); ?>
	</li>
	<li class="even">
		<label>Height</label>
		<?php echo form_input('height', ($options['height'] != '' ? $options['height'] : '400px')); ?>
	</li>
	<li class="odd">
		<label>Zoom Level</label>
		<?php echo form_input('zoom', ($options['zoom'] != '' ? $options['zoom'] : '16')); ?>
	</li>
	<li class="even">
		<label>Description (optional)</label>
		<?php echo form_textarea('description', $options['description']); ?>
	</li>
</ol>