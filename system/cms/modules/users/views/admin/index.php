<section class="padded">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<span class="title"><?php echo lang('user:list_title') ?></span>
		</section>

		<div class="padded">
		
			<?php template_partial('filters') ?>
		
			<?php echo form_open('admin/users/action') ?>
			
				<div id="filter-stage">
					<?php template_partial('tables/users') ?>
				</div>
			
				<div class="btn-group">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('activate', 'delete') )) ?>
				</div>
		
			<?php echo form_close() ?>

		</div>

	</section>


</div>
</section>