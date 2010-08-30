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
	<li>
		<?php echo $file; ?>
		<?php echo $status ? '<em class="pass">{writable}</em>' : '<em class="fail">{not_writable}</em>'; ?></li>
<?php endforeach; ?>
</ul>

<?php if($step_passed): ?>
	<a id="next_step" href="<?php echo site_url('installer/step_4'); ?>" title="{next_step}">{step4}</a>
<?php else: ?>
	<a id="next_step" href="<?php echo site_url('installer/step_3'); ?>">{retry}</a>
<?php endif; ?>