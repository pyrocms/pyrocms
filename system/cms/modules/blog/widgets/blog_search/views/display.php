<?php echo form_open('blog/search');?>
	<?php echo form_input(
		array(
			'name'	=> 'b_keywords',
			'placeholder'	=> 'Press enter to search...',
		));
	?>
<?php echo form_close(); ?>