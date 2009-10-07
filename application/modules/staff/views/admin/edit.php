<h3><?= sprintf(lang('staff_edit_title'), $member->name);?></h3>

<?= form_open_multipart('admin/staff/edit/' . $member->slug); ?>
	<?= form_hidden('user_id', $member->user_id); ?>
	<?= image('staff/' . $member->filename, '', array('title'=>$member->name));?>	
	<? if($member->user_id > 0): ?>
		<div class="if-user">
			<div class="field">
				<label><?= lang('staff_name_label');?></label>
				<p><?= $member->name; ?></p>
			</div>	
			<div class="field">
				<label><?= lang('staff_email_label');?></label>
				<p><?= $member->email; ?></p>
			</div>
		</div>
	<? else: ?>
		<div class="if-not-user">
			<div class="field">
				<label for="name"><?= lang('staff_name_label');?></label>
				<?= form_input('name', $member->name, 'class="text" maxlength="40"'); ?>
			</div>	
			<div class="field">
				<label for="email"><?= lang('staff_email_label');?></label>
				<?= form_input('email', $member->email, 'class="text" maxlength="40"'); ?>
			</div>
		</div>
	<? endif; ?>
	
	<div class="field">
		<label for="userfile"><?= lang('staff_photo_change_label');?></label>
		<input type="file" class="text" name="userfile" id="userfile" maxlength="100" value="" />
	</div>
	
	<div class="field">
		<label for="position"><?= lang('staff_job_title_label');?></label>
		<?= form_input('position', $member->position, 'class="text" maxlength="40"'); ?>
	</div>
	
	<div class="field">
		<label for="fact"><?= lang('staff_random_fact_label');?></label>
		<?= form_input('fact', $member->fact, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label><?= lang('staff_biography_label');?></label>
		<?=form_textarea(array('id'=>'body', 'name'=>'body', 'value' => $member->body, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
	</div>
	
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>