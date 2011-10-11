<ul>
	<li class="even">
		<label>Mode</label>
		<?php echo form_dropdown('mode', array('default'=>'Default', 'vertical' => 'Vertical', 'two_column' => 'Two Column'), $options['mode']); ?>
	</li>
</ul>

<?php //echo js('codemirror/codemirror.js'); ?>
<?php /*<script type="text/javascript" defer="defer">
	html_editor('html_editor', "25em");
</script> */ ?>