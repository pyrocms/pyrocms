<h3><?=lang('nav_group_create_title');?></h3>    
<?= form_open('admin/navigation/groups/create'); ?>

	<fieldset>	
		<legend><?=lang('nav_group_label');?></legend>
			
		<div class="field">
			<label for="title"><?=lang('nav_title_label');?></label>
			<?= form_input('title', $this->validation->title, 'class="text"'); ?>
		</div>	
		
		<div class="field">
			<label for="url"><?=lang('nav_abbrev_label');?></label>
			<?= form_input('abbrev', $this->validation->abbrev, 'class="text"'); ?>
		</div>
			
	</fieldset>
	
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>