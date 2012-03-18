<section class="title">
	<?php if ($this->method == 'create'): ?>
		<h4><?php echo lang('user_add_title');?></h4>
		<?php echo form_open(uri_string(), 'class="crud" autocomplete="off"'); ?>
	
	<?php else: ?>
		<h4><?php echo sprintf(lang('user_edit_title'), $member->username);?></h4>
		<?php echo form_open(uri_string(), 'class="crud"'); ?>
	<?php endif; ?>
</section>

<section class="item">
	
	<div class="tabs">

		<ul class="tab-menu">
			<li><a href="#user-basic-data-tab"><span><?php echo lang('profile_user_basic_data_label');?></span></a></li>
			<li><a href="#user-profile-fields-tab"><span><?php echo lang('user_profile_fields_label');?></span></a></li>
		</ul>

		<!-- Content tab -->
		<div class="form_inputs" id="user-basic-data-tab">
			<fieldset>
				<ul>
					<li class="even">
						<label for="email"><?php echo lang('user_email_label');?> <span>*</span></label>
						<div class="input">
							<?php echo form_input('email', $member->email, 'id="email"'); ?>
						</div>
					</li>
					
					<li>
						<label for="username"><?php echo lang('user_username');?> <span>*</span></label>
						<div class="input">
						<?php echo form_input('username', $member->username, 'id="username"'); ?>
						</div>
					</li>

					<li>
						<label for="group_id"><?php echo lang('user_group_label');?></label>
						<div class="input">
						<?php echo form_dropdown('group_id', array(0 => lang('global:select-pick')) + $groups_select, $member->group_id, 'id="group_id"'); ?>
						</div>
					</li>
					
					<li class="even">
						<label for="active"><?php echo lang('user_activate_label');?></label>
						<div class="input">
						<?php echo form_checkbox('active', 1, (isset($member->active) && $member->active == 1), 'id="active"'); ?>
						</div>
					</li>
					<li class="even">
						<label for="password">
							<?php echo lang('user_password_label');?>
							<?php if ($this->method == 'create'): ?> <span>*</span><?php endif; ?>
						</label>
						<div class="input">
							<?php echo form_password('password', '', 'id="password" autocomplete="off"'); ?>
						</div>
					</li>
				</ul>
			</fieldset>
		</div>

		<div class="form_inputs" id="user-profile-fields-tab">

			<fieldset>
				<ul>

					<li>
						<label for="display_name"><?php echo lang('profile_display_name');?> <span>*</span></label>
						<div class="input">
						<?php echo form_input('display_name', $display_name, 'id="display_name"'); ?>
						</div>
					</li>

					<?php foreach($profile_fields as $field) { ?>
					<li>
						<label for="<?php echo $field['field_slug']; ?>">
							<?php echo (lang($field['field_name'])) ? lang($field['field_name']) : $field['field_name'];  ?>
							<?php if ($field['required']){ ?> <span>*</span><?php } ?>
						</label>
						<div class="input">
							<?php echo $field['input']; ?>
						</div>
					</li>
					<?php } ?>

				</ul>
			</fieldset>
		</div>
	</div>

	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

<?php echo form_close(); ?>

</section>