<script type="text/javascript">
(function ($) {
	$(function(){

		// Stops Firefox from being an ass and remembering YOUR password in this box
		//this doesn't work... I just lost an hour to this firefox you douche!
		$('input[name="password"], input[name="confirm_password"]').val('');

	});
})(jQuery);
</script>


<?php if ($this->method == 'create'): ?>
	<h3><?php echo lang('user_add_title');?></h3>

<?php else: ?>
	<h3><?php echo sprintf(lang('user_edit_title'), $member->full_name);?></h3>
<?php endif; ?>

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
						<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
					</li>

					<li>
						<label for="last_name"><?php echo lang('user_last_name_label');?></label>
						<?php echo form_input('last_name', $member->last_name); ?>
					</li>

					<li class="even">
						<label for="email"><?php echo lang('user_email_label');?></label>
						<?php echo form_input('email', $member->email); ?>
						<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
					</li>

					<li>
						<label for="username"><?php echo lang('user_username');?></label>
						<?php echo form_input('username', $member->username); ?>
						<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
					</li>

					<li class="even">
						<label for="display_name"><?php echo lang('user_display_name');?></label>
						<?php echo form_input('display_name', $member->display_name); ?>
					</li>

					<li>
						<label for="group_id"><?php echo lang('user_group_label');?></label>
						<?php echo form_dropdown('group_id', array(0 => lang('select.pick')) + $groups_select, $member->group_id); ?>
					</li>

					<li class="even">
						<label for="active"><?php echo lang('user_activate_label');?></label>
						<?php echo form_checkbox('active', 1, (isset($member->active) && $member->active == 1)); ?>
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
						<?php if ($this->method == 'create'): ?>
						<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
						<?php endif; ?>
					</li>

					<li>
						<label for="confirm_password"><?php echo lang('user_password_confirm_label');?></label>
						<?php echo form_password('confirm_password'); ?>
						<?php if ($this->method == 'create'): ?>
						<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
						<?php endif; ?>
					</li>
				</ol>
			</fieldset>
		</div>
	</div>

	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

<?php echo form_close(); ?>