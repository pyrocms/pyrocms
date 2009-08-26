<!-- Install PyroCMS - Step one -->
<h2>Step 1: Check requirements</h2>
<p>The first step in the installation process is to check whether your server supports PyroCMS. Most servers should be able to run it without any trouble.</p>

<!-- PHP Settings -->
<h3>PHP Settings</h3>
<p>PyroCMS requires PHP version 5.0 or higher. Your server is currently running version <?php echo $php_version; ?>, which is <?php echo $php_results; ?> by PyroCMS.</p>

<!-- MySQL settings -->
<h3>MySQL Settings</h3>
<p>PyroCMS requires access to a MySQL database running version 5.0 or higher. Your server is currently running <?php echo $mysql_server; ?> and the client library version is <?php echo $mysql_client; ?>.</p>

<!-- GD Settings -->
<h3>GD Settings</h3>
<p>PyroCMS requires access to the GD image library for several tasks, such as resizing gallery images. Therefore it requires this library to be installed and up to date.</p><p><?php if($gd_version != false): ?>You are currently running version <?php echo $gd_version; ?> of the GD image library.<?php else: ?><span class="red">It seems the GD library isn't installed on your server. Try contacting your host to see if they can install it for you.</span><?php endif; ?></p>

<!-- Summary -->
<h3>Summary</h3>

<?php if($server_supported === TRUE): ?>
<p class="green"><strong>Your server meets all the requirements for PyroCMS to run properly, go to the next step by clicking the button below.</strong></p>
<p id="next_step"><a href="<?php echo site_url('installer/step_2'); ?>" title="Proceed to the next step">Step 2</a></p>

<?php elseif($server_supported == 'partial'): ?>
<p class="yellow"><strong>Your server meets most of the requirements for PyroCMS to run properly. You should expect strange results until you fix these requirements.</strong></p>
<p id="next_step"><a href="<?php echo site_url('installer/step_2'); ?>" title="Proceed to the next step">Step 2</a></p>

<?php else: ?>
<p class="red"><strong>It seems that your server failed to meet all the requirements for PyroCMS to run properly, please validate the results or carry on at your own peril.</strong></p>
<?php endif; ?>

<br class="clear" />