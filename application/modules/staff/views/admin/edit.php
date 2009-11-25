<h3><?php echo sprintf(lang('staff_edit_title'), $member->name);?></h3>

<?php echo form_open_multipart('admin/staff/edit/' . $member->slug); ?>
	<?php echo form_hidden('user_id', $member->user_id); ?>
	<?php echo image('staff/' . $member->filename, '', array('title'=>$member->name));?>	
	<?php if($member->user_id > 0): ?>
		<div class="if-user">
			<div class="field">
				<label><?php echo lang('staff_name_label');?></label>
				<p><?php echo $member->name; ?></p>
			</div>	
			<div class="field">
				<label><?php echo lang('staff_email_label');?></label>
				<p><?php echo $member->email; ?></p>
			</div>
		</div>
	<?php else: ?>
		<div class="if-not-user">
			<div class="field">
				<label for="name"><?php echo lang('staff_name_label');?></label>
				<?php echo form_input('name', $member->name, 'class="text" maxlength="40"'); ?>
			</div>	
			<div class="field">
				<label for="email"><?php echo lang('staff_email_label');?></label>
				<?php echo form_input('email', $member->email, 'class="text" maxlength="40"'); ?>
			</div>
		</div>
	<?php endif; ?>
	
	<div class="field">
		<label for="userfile"><?php echo lang('staff_photo_change_label');?></label>
		<input type="file" class="text" name="userfile" id="userfile" maxlength="100" value="" />
	</div>
	
	<div class="field">
		<label for="position"><?php echo lang('staff_job_title_label');?></label>
		<?php echo form_input('position', $member->position, 'class="text" maxlength="40"'); ?>
	</div>
	
	<div class="field">
		<label for="fact"><?php echo lang('staff_random_fact_label');?></label>
		<?php echo form_input('fact', $member->fact, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label><?php echo lang('staff_biography_label');?></label>
		<?php echo form_textarea(array('id'=>'body', 'name'=>'body', 'value' => $member->body, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
	</div>
	
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>