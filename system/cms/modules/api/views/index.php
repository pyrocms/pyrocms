<section class="title">
	<h4><?php echo $module_details['name']; ?></h4>
</section>

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
			
			$.post(url, { api_status: status }, function() {
				
				$button.hide().siblings('button').show().removeClass('hidden');
				$('div.status').text(parseInt(status) ? lang_enabled : lang_disabled);
				
			});
			
		});
		
	});
</script>

<section class="item">
	
	<!-- Content tab -->
	<div class="form_inputs">
		
		<fieldset>
	
			<ul>
				<li>
					<label for="title">
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
			</ul>
		
		</fieldset>
		
	</div>
	
	
</section>