<!-- Install PyroCMS - Step two -->
<h2><?php echo lang('header'); ?></h2>
<p class="text"><?php echo lang('intro_text'); ?></p>


<!-- Server settings -->
<h3><?php echo lang('server_setting'); ?></h3>
<?php if($http_server->supported === TRUE): ?>
	<img src="<?php echo base_url(); ?>assets/images/icons/tick.png" alt="pass" class="icon" />
<?php else: ?>
	<img src="<?php echo base_url(); ?>assets/images/icons/bullet_error.png" alt="partial pass" class="icon" />
<?php endif; ?>
<p><?php echo lang('server_version'); ?> <strong><?php echo $http_server->name;?></strong>.</p>

<?php if($http_server->supported === FALSE): ?>
	<p class="red text"><?php echo lang('server_fail'); ?></p>
<?php endif; ?>

	
<!-- PHP settings -->
<h3><?php echo lang('php_settings'); ?></h3>
<?php if ($php_version): ?>
	<img src="<?php echo base_url(); ?>assets/images/icons/tick.png" alt="pass" class="icon" />
<?php else: ?>
	<img src="<?php echo base_url(); ?>assets/images/icons/exclamation.png" alt="fail" class="icon"/>
<?php endif; ?>
<p>
	<?php echo lang('php_required'); ?><br />
	<?php echo lang('php_version'); ?> <strong><?php echo $php_version; ?></strong>.
</p>

<?php if ($php_version === FALSE): ?>
	<p class="red text"><?php echo lang('php_fail'); ?></p>
<?php endif; ?>


<!-- MySQL settings -->
<h3><?php echo lang('mysql_settings'); ?></h3>
<?php if ($mysql->server_version && $mysql->client_version): ?>
	<img src="<?php echo base_url(); ?>assets/images/icons/tick.png" alt="pass" class="icon" />
<?php else: ?>
	<img src="<?php echo base_url(); ?>assets/images/icons/exclamation.png" alt="fail" class="icon"/>
<?php endif; ?>
<p>
	<?php echo lang('mysql_required'); ?> <br />
	<?php echo lang('mysql_version1'); ?> <strong><?php echo $mysql->server_version; ?></strong> <br />
	<?php echo lang('mysql_version2'); ?> <strong><?php echo $mysql->client_version; ?></strong>
</p>

<?php if ($mysql->server_version === FALSE OR $mysql->client_version === FALSE): ?>
	<p class="red text"><?php echo lang('mysql_fail'); ?></p>
<?php endif; ?>


<!-- GD settiings -->
<h3><?php echo lang('gd_settings'); ?></h3>
<?php if ( ! empty($gd_version) && $gd_version !== FALSE): ?>
	<img src="<?php echo base_url(); ?>assets/images/icons/tick.png" alt="pass" class="icon" />
<?php else: ?>
	<img src="<?php echo base_url(); ?>assets/images/icons/bullet_error.png" alt="partial pass" class="icon" />
<?php endif; ?>
<p>
	<?php echo lang('gd_required'); ?> <br />
	<?php if( ! empty($gd_version)): ?>
		<?php echo lang('gd_version'); ?> <strong><?php echo $gd_version; ?></strong>
	<?php endif; ?>
</p>

<?php if (empty($gd_version) OR $gd_version === FALSE): ?>
	<p class="red text"><?php echo lang('gd_fail'); ?></p>
<?php endif; ?>

<!-- Zlib -->
<h3><?php echo lang('zlib'); ?></h3>
<?php if ($zlib_enabled): ?>
	<img src="<?php echo base_url(); ?>assets/images/icons/tick.png" alt="pass" class="icon" />
<?php else: ?>
	<img src="<?php echo base_url(); ?>assets/images/icons/bullet_error.png" alt="partial pass" class="icon" />
<?php endif; ?>
<p>
	<?php echo lang('zlib_required'); ?> <br />
	<?php if(!$zlib_enabled): ?>
		<p class="red text"><?php echo lang('zlib_fail'); ?></p>
	<?php endif; ?>
</p>

<!-- Summary -->
<h3><?php echo lang('summary'); ?></h3>

<?php if($step_passed === TRUE): ?>

	<p class="green">
		<strong><?php echo lang('summary_green'); ?></strong>
	</p>
	<p id="next_step">
		<a href="<?php echo site_url('installer/step_3'); ?>" title="<?php echo lang('next_step'); ?>"><?php echo lang('step3'); ?></a>
	</p>

<?php elseif($step_passed == 'partial'): ?>

	<p class="orange">
		<strong><?php echo lang('summary_orange'); ?></strong>
	</p>
	<p id="next_step">
		<a href="<?php echo site_url('installer/step_3'); ?>" title="<?php echo lang('next_step'); ?>"><?php echo lang('step3'); ?></a>
	</p>

<?php else: ?>

	<p class="red">
		<strong><?php echo lang('summary_red'); ?></strong>
	</p>
	<p id="next_step">
		<a href="<?php echo site_url('installer/step_2'); ?>"><?php echo lang('retry'); ?></a>
	</p>
<?php endif; ?>

<br class="clear" />
