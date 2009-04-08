<html>
	<body>
	
		<?=form_open('utilities/sneak/fetch', array('target'=>'fetch')); ?>
	
		http://<?=form_input('url', $url) ?>
		<?=form_submit('', 'GO') ?>
	
		<?=form_close(); ?>
	</body>
</html>