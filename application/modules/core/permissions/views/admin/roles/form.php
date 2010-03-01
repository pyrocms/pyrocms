<div class="box">

	<?php if($this->uri->segment(4,'create') == 'create'): ?>
		<h3><?php echo lang('perm_role_add');?></h3>	
	<?php else: ?>
		<h3><?php echo sprintf(lang('perm_role_edit_title'), $permission_role->title);?></h3>
	<?php endif; ?>

	<div class="box-container">
	
		<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
		
		<fieldset>
			<ol>
				<li>
					<label for="title"><?php echo lang('perm_title_label');?></label>
					<?php echo form_input('title', $permission_role->title, 'class="text"'); ?>
				</li>
				
				<li class="even">
					<label for="abbrev"><?php echo lang('perm_abbrev_label');?></label>	
					<?php if($this->uri->segment(4,'create') == 'create'): ?>
						<?php echo form_input('abbrev', $permission_role->abbrev, 'class="text width-10"'); ?>	
					<?php else: ?>
						<?php echo $permission_role->abbrev; ?>
					<?php endif; ?>
				</li>
			</ol>
		</fieldset>
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		<?php echo form_close(); ?>
		
	</div>
</div>