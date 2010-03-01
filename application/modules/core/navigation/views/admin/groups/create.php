<div class="box">
	
	<h3><?php echo lang('nav_group_create_title');?></h3> 
	
	<div class="box-container">
	
		<?php echo form_open('admin/navigation/groups/create', 'class="crud"'); ?>
		
			<fieldset>	
				<ol>
					<li class="even">
						<label for="title"><?php echo lang('nav_title_label');?></label>
						<?php echo form_input('title', $this->validation->title, 'class="text"'); ?>
					</li>
				
					<li>
						<label for="url"><?php echo lang('nav_abbrev_label');?></label>
						<?php echo form_input('abbrev', $this->validation->abbrev, 'class="text"'); ?>
					</li>
				</ol>
			</fieldset>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		<?php echo form_close(); ?>
		
	</div>
</div>