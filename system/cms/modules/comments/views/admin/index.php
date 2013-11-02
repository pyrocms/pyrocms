<div class="p n-p-b">
	<?php file_partial('notices'); ?>
</div>

<div class="p">


	<section id="page-title">
		<h1><?php echo lang('comments:title') ?></h1>
	</section>


	<!-- .panel -->
	<section class="panel panel-default">

		<!-- .panel-content -->
		<div class="panel-content">


			<?php echo $this->load->view('admin/partials/filters') ?>

			<?php echo form_open('admin/comments/action');?>

				<?php echo form_hidden('redirect', uri_string()) ?>

				<div id="filter-stage">

					<?php echo $this->load->view('admin/tables/comments') ?>

				</div>

				<div class="panel-footer">

					<?php if (Settings::get('moderate_comments')): ?>
						<?php if ( ! $comments_active): ?>
							<?php $this->load->view('admin/partials/buttons', array('buttons' => array('approve','delete'))) ?>
						<?php else: ?>
							<?php $this->load->view('admin/partials/buttons', array('buttons' => array('unapprove','delete'))) ?>
						<?php endif ?>
					<?php else: ?>
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))) ?>
					<?php endif ?>
				</div>

			<?php echo form_close();?>


		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>