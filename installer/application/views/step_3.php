<h2>Step 3: Set permissions</h2>
<p>Before PyroCMS can be installed you need to make sure that certain files and folders are writeable, these files and folders are listed below.</p>
<h3>Folder Permissions</h3>
<p>The CHMOD values of the following folders must be changed to 777 (in some cases 775 works too).</p>
<ul class="perm_list" id="perm_folders">
	<li>codeigniter/cache <?php echo $perm_status['codeigniter/cache'] ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
	<li>codeigniter/logs <?php echo $perm_status['codeigniter/logs'] ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
	<li>application/cache <?php echo $perm_status['application/cache'] ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
	<li>application/uploads <?php echo $perm_status['application/uploads'] ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
	<li>application/assets/img/galleries <?php echo $perm_status['application/assets/img/galleries'] ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
	<li>application/assets/img/products <?php echo $perm_status['application/assets/img/products'] ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
	<li>application/assets/img/staff <?php echo $perm_status['application/assets/img/staff'] ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
	<li>application/assets/img/suppliers <?php echo $perm_status['application/assets/img/suppliers'] ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
</ul>
<h3>File Permissions</h3>
<p>The CHMOD values of the following files must be changed to 777 (in some cases 775 works too). It's very important to change the file permissions of the database file <em>before</em> installing PyroCMS.</p>
<ul class="perm_list" id="perm_files">
	<li>application/config/config.php <?php echo $perm_status['application/config/config.php'] ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
	<li>application/config/database.php <?php echo $perm_status['application/config/database.php'] ? '- <span class="green">Writable</span>' : '- <span class="red">Not writable</span>'; ?></li>
</ul>

<?php if($step_passed): ?>
<p id="next_step"><a href="<?php echo site_url('installer/step_4'); ?>" title="Proceed to the next step">Step 4</a></p>
<?php else: ?>
<p id="next_step"><a href="<?php echo site_url('installer/step_3'); ?>">Try again</a></p>
<?php endif; ?>
<br class="clear" />