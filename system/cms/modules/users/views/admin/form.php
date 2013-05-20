<section class="padded">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">

			<?php if ($this->method === 'create'): ?>
				<span class="title"><?php echo lang('user:add_title') ?></span>
			<?php else: ?>
				<span class="title"><?php echo sprintf(lang('user:edit_title'), $member->username) ?></span>
			<?php endif ?>

		</section>
		
			
		<!-- Tabs -->
		<ul class="nav nav-tabs padded no-padding-bottom grayLightest-bg">
			<li class="active">
				<a href="#user-basic-data-tab" data-toggle="tab"><span><?php echo lang('profile_user_basic_data_label') ?></span></a>
			</li>
			<li>
				<a href="#user-profile-fields-tab" data-toggle="tab"><span><?php echo lang('user:profile_fields_label') ?></span></a>
			</li>
		</ul>


		<?php if ($this->method === 'create'): ?>
			<?php echo form_open_multipart(uri_string(), 'class="crud" autocomplete="off"') ?>
		<?php else: ?>
			<?php echo form_open_multipart(uri_string(), 'class="crud"') ?>
			<?php echo form_hidden('row_edit_id', isset($member->row_edit_id) ? $member->row_edit_id : $member->profile_id); ?>
		<?php endif ?>


		<!-- .tab-content -->
		<div class="tab-content">

			<!-- Content tab -->
			<div class="tab-pane active" id="user-basic-data-tab">

				<fieldset>
					<ul>
						<li class="row-fluid input-row">
							<label class="span3" for="email"><?php echo lang('global:email') ?> <span>*</span></label>
							<div class="input span9">
								<?php echo form_input('email', $member->email, 'id="email"') ?>
							</div>
						</li>
						
						<li class="row-fluid input-row">
							<label class="span3" for="username"><?php echo lang('user:username') ?> <span>*</span></label>
							<div class="input span9">
								<?php echo form_input('username', $member->username, 'id="username"') ?>
							</div>
						</li>
	
						<li class="row-fluid input-row">
							<label class="span3" for="group_id"><?php echo lang('user:group_label') ?></label>
							<div class="input span9">
								<?php echo form_dropdown('group_id', array(0 => lang('global:select-pick')) + $groups_select, $member->group_id, 'id="group_id"') ?>
							</div>
						</li>
						
						<li class="row-fluid input-row">
							<label class="span3" for="active"><?php echo lang('user:activate_label') ?></label>
							<div class="input span9">
								<?php $options = array(0 => lang('user:do_not_activate'), 1 => lang('user:active'), 2 => lang('user:send_activation_email')) ?>
								<?php echo form_dropdown('active', $options, $member->active, 'id="active"') ?>
							</div>
						</li>
						<li class="row-fluid input-row">
							<label class="span3" for="password">
								<?php echo lang('global:password') ?>
								<?php if ($this->method == 'create'): ?> <span>*</span><?php endif ?>
							</label>
							<div class="input span9">
								<?php echo form_password('password', '', 'id="password" autocomplete="off"') ?>
							</div>
						</li>
					</ul>
				</fieldset>

			</div>
	

			<!-- Another tab -->
			<div class="tab-pane" id="user-profile-fields-tab">
	
				<fieldset>
					<ul>
	
						<li class="row-fluid input-row">
							<label class="span3" for="display_name"><?php echo lang('profile_display_name') ?> <span>*</span></label>
							<div class="input span9">
								<?php echo form_input('display_name', $display_name, 'id="display_name"') ?>
							</div>
						</li>
	
						<?php foreach($profile_fields as $field): ?>
						<li class="row-fluid input-row">
							<label class="span3" for="<?php echo $field['field_slug'] ?>">
								<?php echo (lang($field['field_name'])) ? lang($field['field_name']) : $field['field_name'];  ?>
								<?php if ($field['required']){ ?> <span>*</span><?php } ?>
							</label>
							<div class="input span9">
								<?php echo $field['input'] ?>
							</div>
						</li>
						<?php endforeach ?>
	
					</ul>
				</fieldset>

			</div>


		</div>
		<!-- /.tab-content -->


		<div class="btn-group padded">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )) ?>
		</div>
		
		<?php echo form_close() ?>

	</section>


</div>
</section>