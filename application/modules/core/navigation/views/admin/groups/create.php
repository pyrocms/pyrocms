<h3><?php echo lang('nav_group_create_title');?></h3>    
<?php echo form_open('admin/navigation/groups/create'); ?>

	<fieldset>	
		<legend><?php echo lang('nav_group_label');?></legend>
			
		<div class="field">
			<label for="title"><?php echo lang('nav_title_label');?></label>
			<?php echo form_input('title', $this->validation->title, 'class="text"'); ?>
		</div>	
		
		<div class="field">
			<label for="url"><?php echo lang('nav_abbrev_label');?></label>
			<?php echo form_input('abbrev', $this->validation->abbrev, 'class="text"'); ?>
		</div>
			
	</fieldset>
	
	<?php $this->load->view('admin/partials/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>