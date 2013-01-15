<section class="title">
	<?php if ($this->method === 'create'): ?>
		<h4><?php echo lang('user:add_title') ?></h4>
		<?php echo form_open_multipart(uri_string(), 'class="crud" autocomplete="off"') ?>
	
	<?php else: ?>
		<h4><?php echo sprintf(lang('user:edit_title'), $member->username) ?></h4>
		<?php echo form_open_multipart(uri_string(), 'class="crud"') ?>
		<?php echo form_hidden('row_edit_id', isset($member->row_edit_id) ? $member->row_edit_id : $member->profile_id); ?>
	<?php endif ?>
</section>

<section class="item">
	<div class="content">
	
		<div class="tabs">
	
			<ul class="tab-menu">
				<li><a href="#user-basic-data-tab"><span><?php echo lang('profile_user_basic_data_label') ?></span></a></li>
				<li><a href="#user-profile-fields-tab"><span><?php echo lang('user:profile_fields_label') ?></span></a></li>
			</ul>
	
			<!-- Content tab -->
			<div class="form_inputs" id="user-basic-data-tab">
				<fieldset>
					<ul>
						<li class="even">
							<label for="email"><?php echo lang('global:email') ?> <span>*</span></label>
							<div class="input">
								<?php echo form_input('email', $member->email, 'id="email"') ?>
							</div>
						</li>
						
						<li>
							<label for="username"><?php echo lang('user:username') ?> <span>*</span></label>
							<div class="input">
								<?php echo form_input('username', $member->username, 'id="username"') ?>
							</div>
						</li>
	
						<li>
							<label for="group_id"><?php echo lang('user:group_label') ?></label>
							<div class="input">
								<?php echo form_dropdown('group_id', array(0 => lang('global:select-pick')) + $groups_select, $member->group_id, 'id="group_id"') ?>
							</div>
						</li>
						
						<li class="even">
							<label for="active"><?php echo lang('user:activate_label') ?></label>
							<div class="input">
								<?php $options = array(0 => lang('user:do_not_activate'), 1 => lang('user:active'), 2 => lang('user:send_activation_email')) ?>
								<?php echo form_dropdown('active', $options, $member->active, 'id="active"') ?>
							</div>
						</li>
						<li class="even">
							<label for="password">
								<?php echo lang('global:password') ?>
								<?php if ($this->method == 'create'): ?> <span>*</span><?php endif ?>
							</label>
							<div class="input">
								<?php echo form_password('password', '', 'id="password" autocomplete="off"') ?>
							</div>
						</li>
					</ul>
				</fieldset>
			</div>
	
			<div class="form_inputs" id="user-profile-fields-tab">
	
				<fieldset>
					<ul>
	
						<li>
							<label for="display_name"><?php echo lang('profile_display_name') ?> <span>*</span></label>
							<div class="input">
								<?php echo form_input('display_name', $display_name, 'id="display_name"') ?>
							</div>
						</li>
	
						<?php foreach($profile_fields as $field): ?>
						<li>
							<label for="<?php echo $field['field_slug'] ?>">
								<?php echo (lang($field['field_name'])) ? lang($field['field_name']) : $field['field_name'];  ?>
								<?php if ($field['required']){ ?> <span>*</span><?php } ?>
							</label>
							<div class="input">
								<?php echo $field['input'] ?>
							</div>
						</li>
						<?php endforeach ?>
	
					</ul>
				</fieldset>
			</div>
		</div>

		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )) ?>
		</div>
	
	<?php echo form_close() ?>

	</div>
</section>