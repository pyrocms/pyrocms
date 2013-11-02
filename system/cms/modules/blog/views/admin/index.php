<div class="p n-p-b">
	<?php file_partial('notices'); ?>
</div>

<div class="p">

	<!-- .panel -->
	<section class="panel panel-default">

		<div class="panel-heading">
			<h3 class="panel-title">
				<?php echo lang('blog:posts_title') ?>
			</h3>
		</div>

		<!-- .panel-body -->
		<div class="panel-body">


			<?php if ($blog) : ?>
				<?php echo $this->load->view('admin/partials/filters') ?>

				<?php echo form_open('admin/blog/action') ?>
					<div id="filter-stage">
						<?php echo $this->load->view('admin/tables/posts') ?>
					</div>
				<?php echo form_close() ?>
			<?php else : ?>
				<div class="alert alert-info"><?php echo lang('blog:currently_no_posts') ?></div>
			<?php endif ?>


		</div>
		<!-- /.panel-body -->

	</section>
	<!-- /.panel -->

</div>