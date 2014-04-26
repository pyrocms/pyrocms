<!-- Install PyroCMS - Step two -->
<section class="title">
	<h3>{header}</h3>
</section>
<section class="item">
	<p>{intro_text}</p>
</section>

<!-- Recommended -->
<section class="title">
	<h3>{mandatory}</h3>
</section>
<section class="item">
	<ul class="check">

		<!-- Server -->
		<li>
			<h5>{server_settings}</h5>
			<p class="result <?php echo ($http_server_supported === true) ? 'pass' : 'partial'; ?>">
				<?php if ($http_server_supported === true): ?>
					<?php echo $http_server_name; ?>
				<?php else: ?>{server_fail}<?php endif; ?>
			</p>
		</li>

		<!-- PHP -->
		<li>
			<h5>{php_settings}</h5>
			<p><?php echo sprintf(lang('php_required'), $php_min_version); ?></p>
			<p class="result <?php echo ($php_acceptable) ? 'pass' : 'fail'; ?>">
				{php_version} <strong><?php echo $php_running_version; ?></strong>.
				<?php if (!$php_acceptable): ?>
					<?php echo sprintf(lang('php_fail'), $php_min_version); ?>
				<?php endif; ?>
			</p>
		</li>

		<!-- MySQL -->
		<li>
			<h5><?php echo lang('mysql_settings'); ?></h5>
			<p><?php echo lang('mysql_required'); ?></p>
			<!-- Server -->
			<p class="result <?php echo ($server_version_acceptable) ? 'pass' : 'fail'; ?>">
				{mysql_version1} <strong><?php echo $server_version; ?></strong>.
				<?php if ( ! $server_version_acceptable) : ?>{mysql_fail}<?php endif; ?>
			</p>
			<!-- Client -->
			<p class="result <?php echo ($client_version_acceptable) ? 'pass' : 'fail'; ?>">
				{mysql_version2} <strong><?php echo $client_version; ?></strong>.
				<?php if ( ! $client_version_acceptable): ?>{mysql_fail}<?php endif; ?>
			</p>
		</li>
	</ul>
</section>

<!-- Recommended -->
<section class="title">
	<h3>{recommended}</h3>
</section>
<section class="item">
	<ul class="check">
		<!-- GD -->
		<li>
			<h5>{gd_settings}</h5>
			<p>{gd_required}</p>
			<p class="result <?php echo ($gd_acceptable) ? 'pass' : 'fail'; ?>">
				{gd_version} <strong><?php echo $gd_running_version; ?></strong>.
				<?php if (!$gd_acceptable): ?>{gd_fail}<?php endif; ?>
			</p>
		</li>
		<!-- Zlib -->
		<li>
			<h5>{zlib}</h5>
			<p>{zlib_required}</p>
			<p class="result <?php echo ($zlib_enabled) ? 'pass' : 'fail'; ?>">
				<?php if ($zlib_enabled): ?>{zlib}<?php else: ?>{zlib_fail}<?php endif; ?>
			</p>
		</li>

		<!-- Curl -->
		<li>
			<h5>{curl}</h5>
			<p>{curl_required}</p>
			<p class="result <?php echo ($curl_enabled) ? 'pass' : 'fail'; ?>">
				<?php if ($curl_enabled): ?>{curl}<?php else: ?>{curl_fail}<?php endif; ?>
			</p>
		</li>
	</ul>
</section>

<!-- Summary -->
<section class="title">
	<h3>{summary}</h3>
</section>
<section class="item">
<?php if($step_passed === true): ?>
	<p class="success">{summary_success}</p>
	<a class="btn orange" id="next_step" href="<?php echo site_url('installer/step_3'); ?>" title="{next_step}">{step3}</a>
<?php elseif($step_passed == 'partial'): ?>
	<p class="partial">{summary_partial}</p>
	<a class="btn orange" id="next_step" href="<?php echo site_url('installer/step_3'); ?>" title="{next_step}">{step3}</a>
<?php else: ?>
	<p class="failure">{summary_failure}</p>
	<a class="btn orange" id="next_step" href="<?php echo site_url('installer/step_2'); ?>">{retry}</a>
<?php endif; ?>
</section>