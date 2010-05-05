<!-- Install PyroCMS - Step two -->
<?php echo lang('text'); ?>

<?php if($http_server->supported === TRUE): ?>
	<p><?php echo lang('server1'); ?> <strong><?php echo $http_server->name;?></strong> <?php echo lang('server2'); ?></p>
<?php else: ?>
	<p class="red"><?php echo lang('server_fail'); ?></p>
<?php endif; ?>

<h3><?php echo lang('phpsettings'); ?></h3>
<p><?php echo lang('phpversion1'); ?> <strong><?php echo $php_version; ?></strong>, <?php echo lang('phpversion2'); ?> 
<?php echo $php_version ? lang('supported') : lang('notsupported'); ?>.</p>

<h3><?php echo lang('mysqlsettings'); ?></h3>
<p>
	<?php echo lang('mysqlversion1'); ?> <strong><?php echo $mysql->server_version; ?></strong> <?php echo lang('mysqlversion2'); ?> <strong><?php echo $mysql->client_version; ?></strong>
<?php echo lang('mysqlversion3'); ?> <?php echo $mysql->server_version && $mysql->client_version ? lang('supported') : lang('notsupported'); ?>.
</p>

<h3><?php echo lang('gdsettings'); ?></h3>
<p>
	<?php
	echo lang('gdversion1');
	if( ! empty($gd_version)):
		echo lang('gdversion2') . ' <strong>'.$gd_version.'</strong>, '.lang('gdversion3').' '.(($gd_version !== FALSE) ? lang('supported') : lang('notsupported'));'.';
	else:
		echo '<span class="red">'.lang('gdversion_fail').'</span>';
	endif; ?>
</p>

<!-- Summary -->
<h3>Summary</h3>

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