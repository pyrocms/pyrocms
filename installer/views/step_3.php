<h2>{header}</h2>
<p>{intro_text}</p>

<h3>{folder_perm}</h3>
<ul class="perm_list" id="perm_folders">
<?php foreach($permissions['directories'] as $directory => $status): ?>
	<li><?php echo $directory; ?> <?php echo $status ? '- <span class="green">{writable}</span>' : '- <span class="red">{not_writable}</span>'; ?></li>
<?php endforeach; ?>
</ul>

<h3>{file_perm}</h3>
<p>{file_text}</p>
<ul class="perm_list" id="perm_files">
<?php foreach($permissions['files'] as $file => $status): ?>
	<li><?php echo $file; ?> <?php echo $status ? '- <span class="green">{writable}</span>' : '- <span class="red">{not_writable}</span>'; ?></li>
<?php endforeach; ?>
</ul>

<p>
	<a href="#" id="show-commands">+ <?php echo lang('show_commands'); ?></a>
	<a href="#" id="hide-commands" style="display:none">- <?php echo lang('hide_commands'); ?></a>
</p>

<textarea id="commands" style="display:none; margin: 0 0 10px 10px; width:450px;" rows="<?php echo count($permissions['directories']) + count($permissions['files']); ?>">
<?php foreach($permissions['directories'] as $directory => $status): ?>
chmod 777 <?php echo $directory.PHP_EOL; ?>
<?php endforeach; ?>
<?php foreach($permissions['files'] as $files=> $status): ?>
chmod 666 <?php echo $files.PHP_EOL; ?>
<?php endforeach; ?>
</textarea>

<script>
	$(function(){
		$('#show-commands').click(function(){
			$(this).hide();
			$('#hide-commands').show();

			$('#commands').slideDown('slow');

			return false;
		});

		$('#hide-commands').click(function(){
			$(this).hide();
			$('#show-commands').show();

			$('#commands').slideUp('slow');

			return false;
		});
	});
</script>

<?php if($step_passed): ?>
<p id="next_step"><a href="<?php echo site_url('installer/step_4'); ?>" title="{next_step}">{step4}</a></p>
<?php else: ?>
<p id="next_step"><a href="<?php echo site_url('installer/step_3'); ?>">{retry}</a></p>
<?php endif; ?>
<br class="clear" />
