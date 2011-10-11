<h1>{header}</h1>

<p>{intro_text}</p>

<h2>{folder_perm}</h2>

<ul class="permissions folders">
<?php foreach($permissions['directories'] as $directory => $status): ?>
	<li>
		<span><?php echo $directory; ?></span>
		<?php echo $status ? '<em class="pass">{writable}</em>' : '<em class="fail">{not_writable}</em>'; ?>
	</li>
<?php endforeach; ?>
</ul>

<h2>{file_perm}</h2>

<p>{file_text}</p>

<ul class="permissions files">
<?php foreach($permissions['files'] as $file => $status): ?>
	<li><?php echo $file; ?> <?php echo $status ? '<em class="pass">{writable}</em>' : '<em class="fail">{not_writable}</em>'; ?></li>
<?php endforeach; ?>
</ul>

<?php
$cmds_d = '';
$cmds_f ='';
foreach($permissions['directories'] as $directory => $status) {
	$cmds_d .= $status ? '' : 'chmod 777 '.$directory.PHP_EOL;
}
foreach($permissions['files'] as $files => $status) {
	$cmds_f .= $status ? '' : 'chmod 666 '.$files.PHP_EOL;
}
?>
<?php if(!empty($cmds_d) || !empty($cmds_f)): ?>
<p>
	<a href="#" id="show-commands">+ <?php echo lang('show_commands'); ?></a>
	<a href="#" id="hide-commands" style="display:none">- <?php echo lang('hide_commands'); ?></a>
</p>


<textarea id="commands" style="display:none; margin: 0 0 10px 10px; width:450px; background-color: #111; color: limegreen; padding: 0.5em;" rows="<?php echo count($permissions['directories']) + count($permissions['files']); ?>">
<?php echo $cmds_d;?>
<?php echo $cmds_f;?>
</textarea>
<?php endif; ?>

<script>
	$(function(){
		$.get("<?php echo site_url('ajax/statistics');?>");
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
	<a id="next_step" href="<?php echo site_url('installer/step_4'); ?>" title="{next_step}">{step4}</a>
<?php else: ?>
	<a id="next_step" href="<?php echo site_url('installer/step_3'); ?>">{retry}</a>
<?php endif; ?>