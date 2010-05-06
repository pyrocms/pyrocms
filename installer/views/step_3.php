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

<?php if($step_passed): ?>
<p id="next_step"><a href="<?php echo site_url('installer/step_4'); ?>" title="{next_step}">{step4}</a></p>
<?php else: ?>
<p id="next_step"><a href="<?php echo site_url('installer/step_3'); ?>">{retry}</a></p>
<?php endif; ?>
<br class="clear" />
