<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo lang('user:list_title') ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php template_partial('filters') ?>
		
			<?php echo form_open('admin/users/action') ?>
			
				<div id="filter-stage">
					<?php template_partial('tables/users') ?>
				</div>
			
				<div class="table_action_buttons padding-left padding-right">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('activate', 'delete') )) ?>
				</div>
		
			<?php echo form_close() ?>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>