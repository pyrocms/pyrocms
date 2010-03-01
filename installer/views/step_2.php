<!-- Install PyroCMS - Step two -->
<h2>Step 2: Check requirements</h2>
<p>The first step in the installation process is to check whether your server supports PyroCMS. Most servers should be able to run it without any trouble.</p>

<h3>HTTP Server Settings</h3>

<?php if($http_server->supported === TRUE): ?>
	<p>Your server software <strong><?php echo $http_server->name;?></strong> is <span class="green">supported</span>.</p>
<?php else: ?>
	<p class="red">Your server software is <span class="red">not support</span>, therefore PyroCMS may or may not work. As long as your PHP and MySQL installations 
	are up to date PyroCMS should be able to run properly, just without clean URL's.</p>
<?php endif; ?>

<h3>PHP Settings</h3>
<p>PyroCMS requires PHP version 5.0 or higher. Your server is currently running version <strong><?php echo $php_version; ?></strong>, 
which is <?php echo $php_version ? '<span class="green">supported</span>' : '<span class="red">not support</span>'; ?>.</p>

<h3>MySQL Settings</h3>
<p>PyroCMS requires access to a MySQL database running version 5.0 or higher. Your server is currently running 
<strong><?php echo $mysql->server_version; ?></strong> and the client library version is <strong><?php echo $mysql->client_version; ?></strong>
which is <?php echo $mysql->server_version && $mysql->client_version ? '<span class="green">supported</span>' : '<span class="red">not support</span>'; ?>.</p>

<h3>GD Settings</h3>

<p>
	PyroCMS requires GD library 1.0 or higher. Your server is currently running version <strong><?php echo $gd_version; ?></strong>, 
	which is <?php echo $gd_version !== FALSE ? '<span class="green">supported</span>' : '<span class="red">not support</span>'; ?>.
</p>

<!-- Summary -->
<h3>Summary</h3>

<?php if($step_passed === TRUE): ?>
<p class="green"><strong>Your server meets all the requirements for PyroCMS to run properly, go to the next step by clicking the button below.</strong></p>
<p id="next_step"><a href="<?php echo site_url('installer/step_3'); ?>" title="Proceed to the next step">Step 3</a></p>

<?php elseif($step_passed == 'partial'): ?>
<p class="orange"><strong>Your server meets <em>most</em> of the requirements for PyroCMS. This means that PyroCMS should be able to run properly but there is a chance that you will experience problems with things such as image resizing and thumbnail creating.</strong></p>
<p id="next_step"><a href="<?php echo site_url('installer/step_3'); ?>" title="Proceed to the next step">Step 3</a></p>

<?php else: ?>
<p class="red"><strong>It seems that your server failed to meet the requirements to run PyroCMS. Please contact your server administrator or hosting company to get this resolved.</strong></p>
<p id="next_step"><a href="<?php echo site_url('installer/step_2'); ?>">Try again</a></p>
<?php endif; ?>

<br class="clear" />