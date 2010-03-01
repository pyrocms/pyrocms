<h2>Step 3: Set permissions</h2>
<p>Before PyroCMS can be installed you need to make sure that certain files and folders are writeable, these files and folders are listed below. Make sure any subfolders have the correct permissions too !</p>
<h3>Folder Permissions</h3>
<p>The CHMOD values of the following folders must be changed to 777 (in some cases 775 works too).</p>
<ul class="perm_list" id="perm_folders">
<?php foreach($permissions['directories'] as $directory => $status): ?>
	<li><?php echo $directory; ?> <?php echo $status ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
<?php endforeach; ?>
</ul>
<h3>File Permissions</h3>
<p>The CHMOD values of the following files must be changed to 666. It's very important to change the file permissions of the database file <em>before</em> installing PyroCMS.</p>
<ul class="perm_list" id="perm_files">
<?php foreach($permissions['files'] as $file => $status): ?>
	<li><?php echo $file; ?> <?php echo $status ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
<?php endforeach; ?>
</ul>

<?php if($step_passed): ?>
<p id="next_step"><a href="<?php echo site_url('installer/step_4'); ?>" title="Proceed to the next step">Step 4</a></p>
<?php else: ?>
<p id="next_step"><a href="<?php echo site_url('installer/step_3'); ?>">Try again</a></p>
<?php endif; ?>
<br class="clear" />
