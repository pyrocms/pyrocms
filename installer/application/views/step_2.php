<!-- Install PyroCMS - Step two -->
<h2>Step 2: Check requirements</h2>
<p>The first step in the installation process is to check whether your server supports PyroCMS. Most servers should be able to run it without any trouble.</p>

<h3>HTTP Server Settings</h3>

<?php if($http_server->supported === TRUE): ?>
	<p>Your server software <strong><?php echo $http_server->name;?></strong> is supported.</p>
<?php else: ?>
	<p class="red">Your server software is not supported, therefore PyroCMS may or may not work. As long as your PHP and MySQL installations 
	are up to date PyroCMS should be able to run properly, just without clean URL's.</p>
<?php endif; ?>

<h3>PHP Settings</h3>
<p>PyroCMS requires PHP version 5.0 or higher. Your server is currently running version <?php echo $php_version; ?>, 
which is <?php echo $php_version ? 'supported' : '<span class="red">unsupported</span>'; ?> by PyroCMS.</p>

<h3>MySQL Settings</h3>
<p>PyroCMS requires access to a MySQL database running version 5.0 or higher. Your server is currently running 
<?php echo $mysql->server_version; ?> and the client library version is <?php echo $mysql->client_version; ?>.</p>

<h3>GD Settings</h3>
<p>PyroCMS requires access to the GD image library for several tasks, such as resizing images, but it is not installed.</p>

<p>
	<?php if($gd_version !== FALSE): ?>
		You are currently running version <?php echo $gd_version; ?> of the GD image library.
	<?php else: ?>
		<span class="red">
			It seems the GD library isn't installed on your server. Try contacting your host to see if they 
			can install it for you.
		</span>
	<?php endif; ?>
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