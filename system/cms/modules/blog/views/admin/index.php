<div class="padding">


	<section id="page-title">
		<h1><?php echo lang('blog:posts_title') ?></h1>
	</section>


	<!-- .panel -->
	<section class="panel">
	
		<!-- .panel-content -->
		<div class="panel-content">


			<?php if ($blog) : ?>
				<?php echo $this->load->view('admin/partials/filters') ?>

				<?php echo form_open('admin/blog/action') ?>
					<div id="filter-stage">
						<?php echo $this->load->view('admin/tables/posts') ?>
					</div>
				<?php echo form_close() ?>
			<?php else : ?>
				<div class="no_data padding"><?php echo lang('blog:currently_no_posts') ?></div>
			<?php endif ?>


		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>