<!-- Install PyroCMS - Step two -->
<h1><?php echo lang('header'); ?></h1>

<p><?php echo lang('intro_text'); ?></p>

<!-- Recommended -->
<h2><?php echo lang('mandatory'); ?></h2>

<ul class="check">

	<!-- Server -->
	<li>
		<h4><?php echo lang('server_settings'); ?></h4>

		<p class="result <?php echo ($http_server->supported === TRUE) ? 'pass' : 'partial'; ?>">
			<?php if ($http_server->supported === TRUE): ?>
				<?php echo $http_server->name; ?>
			<?php else: ?>
				<?php echo lang('server_fail'); ?>
			<?php endif; ?>
		</p>
	</li>

	<!-- PHP -->
	<li>
		<h4><?php echo lang('php_settings'); ?></h4>
		<p><?php echo sprintf(lang('php_required'), $php_min_version); ?></p>

		<p class="result <?php echo ($php_acceptable) ? 'pass' : 'fail'; ?>">
			<?php echo lang('php_version'); ?> <strong><?php echo $php_version; ?></strong>.
			<?php if (!$php_acceptable): ?>
				<?php echo sprintf(lang('php_fail'), $php_min_version); ?>
			<?php endif; ?>
		</p>

	</li>

	<!-- MySQL -->
	<li>
		<h4><?php echo lang('mysql_settings'); ?></h4>
		<p><?php echo lang('mysql_required'); ?></p>

		<!-- Server -->
		<p class="result <?php echo ($mysql->server_version_acceptable) ? 'pass' : 'fail'; ?>">
			<?php echo lang('mysql_version1'); ?> <strong><?php echo $mysql->server_version; ?></strong>.
			<?php echo ($mysql->server_version_acceptable) ? '' : lang('mysql_fail'); ?>
		</p>

		<!-- Client -->
		<p class="result <?php echo ($mysql->client_version_acceptable) ? 'pass' : 'fail'; ?>">
			<?php echo lang('mysql_version2'); ?> <strong><?php echo $mysql->client_version; ?></strong>.
			<?php echo ($mysql->client_version_acceptable) ? '' : lang('mysql_fail') ; ?>
		</p>

	</li>

</ul>

<!-- Recommended -->
<h2><?php echo lang('recommended'); ?></h2>

<ul class="check">

	<!-- GD -->
	<li>
		<h4><?php echo lang('gd_settings'); ?></h4>
		<p><?php echo lang('gd_required'); ?></p>

		<p class="result <?php echo ($gd_acceptable) ? 'pass' : 'fail'; ?>">
			<?php echo lang('gd_version'); ?> <strong><?php echo $gd_version; ?></strong>.
			<?php if (!$gd_acceptable): ?>
				<?php echo lang('gd_fail'); ?>
			<?php endif; ?>
		</p>
	</li>

	<!-- Zlib -->
	<li>
		<h4><?php echo lang('zlib'); ?></h4>
		<p><?php echo lang('zlib_required'); ?></p>

		<p class="result <?php echo ($zlib_enabled) ? 'pass' : 'fail'; ?>">
			<?php if ($zlib_enabled): ?>
				<?php echo lang('zlib'); ?>
			<?php else: ?>
				<?php echo lang('zlib_fail'); ?>
			<?php endif; ?>
		</p>
	</li>

	<!-- Curl -->
	<li>
		<h4><?php echo lang('curl'); ?></h4>
		<p><?php echo lang('curl_required'); ?></p>

		<p class="result <?php echo ($curl_enabled) ? 'pass' : 'fail'; ?>">
			<?php if ($curl_enabled): ?>
				<?php echo lang('curl'); ?>
			<?php else: ?>
				<?php echo lang('curl_fail'); ?>
			<?php endif; ?>
		</p>
	</li>

</ul>

<!-- Summary -->
<h2><?php echo lang('summary'); ?></h2>

<?php if($step_passed === TRUE): ?>

	<p class="success">
		<?php echo lang('summary_success'); ?>
	</p>

	<a id="next_step" href="<?php echo site_url('installer/step_3'); ?>" title="<?php echo lang('next_step'); ?>"><?php echo lang('step3'); ?></a>

<?php elseif($step_passed == 'partial'): ?>

	<p class="partial">
		<?php echo lang('summary_partial'); ?>
	</p>

	<a id="next_step" href="<?php echo site_url('installer/step_3'); ?>" title="<?php echo lang('next_step'); ?>"><?php echo lang('step3'); ?></a>

<?php else: ?>

	<p class="failure">
		<?php echo lang('summary_failure'); ?>
	</p>

	<a id="next_step" href="<?php echo site_url('installer/step_2'); ?>"><?php echo lang('retry'); ?></a>
<?php endif; ?>