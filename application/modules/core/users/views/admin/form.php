<script type="text/javascript">
(function ($) { 
	$(function(){

		// Stops Firefox from being an ass and remembering YOUR password in this box
		$('input[name="password"], input[name="confirm_password"]').val('');
		
	});
})(jQuery);
</script>

<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>

	<div class="fieldset fieldsetBlock active tabs">
		<div class="header">
			
		<?php if($this->uri->segment(3,'add') == 'add'): ?>
			<h3><?php echo lang('user_add_title');?></h3>
			
		<?php else: ?>
			<h3><?php echo sprintf(lang('user_edit_title'), $member->full_name);?></h3>
		<?php endif; ?>
		
		</div>
		
		<div class="tabs">
			
			<ul class="clear-both">
				<li><a href="#fieldset1"><span><?php echo lang('user_details_label');?></span></a></li>
				<li><a href="#fieldset2"><span><?php echo lang('user_password_label');?></span></a></li>
			</ul>
			
			<!-- Content tab -->
			<fieldset id="fieldset1">
				<legend><?php echo lang('user_details_label');?></legend>
				
				<div class="field">
					<label for="first_name"><?php echo lang('user_first_name_label');?></label>
					<?php echo form_input('first_name', $member->first_name); ?>
				</div>
				
				<div class="field">
					<label for="first_name"><?php echo lang('user_last_name_label');?></label>
					<?php echo form_input('last_name', $member->last_name); ?>
				</div>
				
				<div class="field">
					<label for="email"><?php echo lang('user_email_label');?></label>
					<?php echo form_input('email', $member->email); ?>
				</div>
				
				<div class="field">
					<label for="active"><?php echo lang('user_role_label');?></label>
					<?php echo form_dropdown('role', $roles_select, $member->role); ?>
				</div>
				
				<div class="field">
					<label for="active"><?php echo lang('user_activate_label');?></label>
					<?php echo form_checkbox('is_active', 1, $member->is_active == 1); ?>
				</div>
		
			</fieldset>
	
			<fieldset id="fieldset2">
				<legend><?php echo lang('user_password_label');?></legend>
			
				<div class="field">
					<label for="password"><?php echo lang('user_password_label');?></label>
					<?php echo form_password('password'); ?>
				</div>
				
				<div class="field">
					<label for="confirm_password"><?php echo lang('user_password_confirm_label');?></label>
					<?php echo form_password('confirm_password'); ?>
				</div>
				
			</fieldset>
			
		</div>
	</div>
			
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
	
<?php echo form_close(); ?>