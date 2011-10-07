<section class="title">
	<?php if ($this->method == 'create'): ?>
		<h4><?php echo lang('user_add_title');?></h4>
		<?php echo form_open(uri_string(), 'class="crud" autocomplete="off"'); ?>
	
	<?php else: ?>
		<h4><?php echo sprintf(lang('user_edit_title'), $member->full_name);?></h4>
		<?php echo form_open(uri_string(), 'class="crud"'); ?>
	<?php endif; ?>
</section>

<section class="item">
	
	<div class="tabs">

		<ul class="tab-menu">
			<li><a href="#user-details-tab"><span><?php echo lang('user_details_label');?></span></a></li>
			<li><a href="#user-password-tab"><span><?php echo lang('user_password_label');?></span></a></li>
		</ul>

		<!-- Content tab -->
		<div style="width:100%;" id="user-details-tab">
			<fieldset>
				<ul>
					<li class="even">
						<label for="first_name"><?php echo lang('user_first_name_label');?></label><br>
						<?php echo form_input('first_name', $member->first_name); ?>
						<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
					</li>
					
					<hr>

					<li>
						<label for="last_name"><?php echo lang('user_last_name_label');?></label><br>
						<?php echo form_input('last_name', $member->last_name); ?>
					</li>
					
					<hr>

					<li class="even">
						<label for="email"><?php echo lang('user_email_label');?></label><br>
						<?php echo form_input('email', $member->email); ?>
						<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
					</li>
					
					<hr>

					<li>
						<label for="username"><?php echo lang('user_username');?></label><br>
						<?php echo form_input('username', $member->username); ?>
						<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
					</li>
					
					<hr>

					<li class="even">
						<label for="display_name"><?php echo lang('user_display_name');?></label><br>
						<?php echo form_input('display_name', $member->display_name); ?>
					</li>
					
					<hr>

					<li>
						<label for="group_id"><?php echo lang('user_group_label');?></label><br>
						<?php echo form_dropdown('group_id', array(0 => lang('global:select-pick')) + $groups_select, $member->group_id); ?>
					</li>
					
					<hr>

					<li class="even">
						<label for="active"><?php echo lang('user_activate_label');?></label><br>
						<?php echo form_checkbox('active', 1, (isset($member->active) && $member->active == 1)); ?>
					</li>
				</ul>
			</fieldset>
		</div>

		<div style="width:100%;" id="user-password-tab">
			<fieldset>
				<ul>
					<li class="even">
						<label for="password"><?php echo lang('user_password_label');?></label><br>
						<?php echo form_password('password', '', 'autocomplete="off"'); ?>
						<?php if ($this->method == 'create'): ?>
						<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
						<?php endif; ?>
					</li>
				</ul>
			</fieldset>
		</div>
	</div>

	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

<?php echo form_close(); ?>

</section>