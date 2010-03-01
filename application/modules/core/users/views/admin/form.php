<script type="text/javascript">
(function ($) { 
	$(function(){

		// Stops Firefox from being an ass and remembering YOUR password in this box
		$('input[name="password"], input[name="confirm_password"]').val('');
		
	});
})(jQuery);
</script>

<div class="box">
		
	<?php if($method == 'create'): ?>
		<h3><?php echo lang('user_add_title');?></h3>
		
	<?php else: ?>
		<h3><?php echo sprintf(lang('user_edit_title'), $member->full_name);?></h3>
	<?php endif; ?>
	
	<div class="box-container">
	
		<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
		
			<div class="tabs">
				
				<ul class="tab-menu">
					<li><a href="#user-details-tab"><span><?php echo lang('user_details_label');?></span></a></li>
					<li><a href="#user-password-tab"><span><?php echo lang('user_password_label');?></span></a></li>
				</ul>
				
				<!-- Content tab -->
				<div id="user-details-tab">
					<fieldset>
						<ol>					
							<li class="even">
								<label for="first_name"><?php echo lang('user_first_name_label');?></label>
								<?php echo form_input('first_name', $member->first_name); ?>
							</li>
							
							<li>
								<label for="first_name"><?php echo lang('user_last_name_label');?></label>
								<?php echo form_input('last_name', $member->last_name); ?>
							</li>
							
							<li class="even">
								<label for="email"><?php echo lang('user_email_label');?></label>
								<?php echo form_input('email', $member->email); ?>
							</li>
							
							<li>
								<label for="active"><?php echo lang('user_role_label');?></label>
								<?php echo form_dropdown('role', $roles_select, $member->role); ?>
							</li>
							
							<li class="even">
								<label for="active"><?php echo lang('user_activate_label');?></label>
								<?php echo form_checkbox('is_active', 1, $member->is_active == 1); ?>
							</li>
						</ol>
					</fieldset>
				</div>
		
				<div id="user-password-tab">
					<fieldset>
						<ol>
							<li class="even">
								<label for="password"><?php echo lang('user_password_label');?></label>
								<?php echo form_password('password'); ?>
							</li>
							
							<li>
								<label for="confirm_password"><?php echo lang('user_password_confirm_label');?></label>
								<?php echo form_password('confirm_password'); ?>
							</li>
						</ol>
					</fieldset>
				</div>
			</div>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		
		<?php echo form_close(); ?>
		
	</div>
</div>
