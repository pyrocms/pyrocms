<style>
.form_inputs fieldset > ul > li > label {
	width: 70%;
}
.form_inputs .input {
	float: right !important;
	text-align: right;
	width: 20%;
}

div.status {
	float: left;
	font-weight: bold !important;
	margin: 12px;
}
</style>

<script>

	var lang_disabled = "<?php echo lang('global:disabled') ?>",
		lang_enabled = "<?php echo lang('global:enabled') ?>";
	
	jQuery(function($) {
		
		$('div.form_inputs button[name=api_status]').click(function(){
			
			var url = SITE_URL + 'admin/api/ajax_set_api_status',
				$button = $(this),
				status = $button.val();
			
			$.post(url, { status: status }, function() {
				$button.hide()
					.siblings('button').show().removeClass('hidden')
					.siblings('div.status').text(parseInt(status) ? lang_enabled : lang_disabled);
				return false;
			});
		});
		
		$('div.form_inputs button[name=api_user_keys]').click(function(){
			
			var url = SITE_URL + 'admin/api/ajax_set_api_user_keys',
				$button = $(this),
				status = $button.val();
			
			$.post(url, { status: status }, function() {
				$button.hide()
					.siblings('button').show().removeClass('hidden')
					.siblings('div.status').text(parseInt(status) ? lang_enabled : lang_disabled);
				return false;
			});
		});
		
	});
</script>

<section class="title">
	<h4><?php echo lang('cp_nav_settings'); ?></h4>
</section>

<section class="item">
	
	<!-- Content tab -->
	<div class="form_inputs">
		
		<fieldset>
	
			<ul>
				<li>
					<label>
						<?php echo lang('api:enable_api'); ?>
						<small><?php echo lang('api:enable_api_description'); ?></small>
					</label>
					<div class="input">
						<div class="status">
							<?php echo lang('global:'.(Settings::get('api_enabled') ? 'enabled' : 'disabled')) ?>
						</div>
					
						<button type="button" name="api_status" value="1" class="btn green <?php echo Settings::get('api_enabled') ? 'hidden' : '' ?>">
							<span><?php echo lang('global:enable'); ?></span>
						</button>
						
						<button type="button" name="api_status" value="0" class="btn red <?php echo Settings::get('api_enabled') ? '' : 'hidden' ?>">
							<span><?php echo lang('global:disable'); ?></span>
						</button>
					</div>				
				</li>
				
					<li>
						<label>
							<?php echo lang('api:enable_user_keys'); ?>
							<small><?php echo lang('api:enable_user_keys_description'); ?></small>
						</label>
						<div class="input">
							<div class="status">
								<?php echo lang('global:'.(Settings::get('api_user_keys') ? 'enabled' : 'disabled')) ?>
							</div>

							<button type="button" name="api_user_keys" value="1" class="btn green <?php echo Settings::get('api_user_keys') ? 'hidden' : '' ?>">
								<span><?php echo lang('global:enable'); ?></span>
							</button>

							<button type="button" name="api_user_keys" value="0" class="btn red <?php echo Settings::get('api_user_keys') ? '' : 'hidden' ?>">
								<span><?php echo lang('global:disable'); ?></span>
							</button>
						</div>				
					</li>
			</ul>
		
		</fieldset>
		
	</div>
	
	
</section>


<section class="title">
	<h4><?php echo lang('api:recent_activity'); ?></h4>
</section>

<section class="item">

	<?php if ( ! empty($logs)): ?>
	<table>
		<thead>
			<th>URI</th>
			<th><?php echo lang('api:method') ?></th>
			<th><?php echo lang('api:params') ?></th>
			<th><?php echo lang('api:api_key') ?></th>
			<th><?php echo lang('user_username') ?></th>
			<th>IP</th>
			<th><?php echo lang('global:date') ?></th>
		</thead>
		<tbody>
			<?php foreach ($logs as $log): ?>
			<tr>
				<td><?php echo $log->uri ?></td>
				<td><?php echo strtoupper($log->method) ?></td>
				<td><?php echo print_r(unserialize($log->params)) ?></td>
				<td><?php echo $log->api_key ?></td>
				<td><?php echo $log->user_id === null ? '<em>none</em>' : anchor('users/edit/'.$log->user_id, $log->username) ?></td>
				<td><?php echo $log->ip_address ?></td>
				<td><?php echo format_date($log->time).' '.date('h:i:s', $log->time) ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
		<?php else: ?>
			
			<p><?php echo lang('api:no_logs');?></p>
			
		<?php endif; ?>
	</table>

</section>