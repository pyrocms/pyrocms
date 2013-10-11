<section class="title">
	<h4><?php echo lang('user:list_title') ?></h4>
</section>



<?php template_partial('filters') ?>

<?php echo form_open('admin/users/action') ?>

	<div id="filter-stage">
		<?php template_partial('tables/users') ?>
	</div>

	<div class="panel-footer">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('activate', 'delete') )) ?>
	</div>

<?php echo form_close() ?>
