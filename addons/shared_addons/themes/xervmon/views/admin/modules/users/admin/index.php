<div class="accordion-group">
<section class="title accordion-heading">
	<h4><?php echo lang('user:list_title') ?></h4>
</section>

<div class="accordion-body collapse in lst">
	<div class="content">
	
		<?php template_partial('filters') ?>
	
		<?php echo form_open('admin/users/action') ?>
		
			<div id="filter-stage">
				<?php template_partial('tables/users') ?>
			</div>
		
			<div class="table_action_buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('activate', 'delete') )) ?>
			</div>
	
		<?php echo form_close() ?>
	</div>
</section>
</div>