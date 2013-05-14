<section class="padded">
<div class="container-fluid">

	
	<div class="box">
		
		<section class="box-header">
			<span class="title"><?php echo lang('blog:posts_title') ?></span>
		</section>

		<section class="padded">

				<?php if ($blog) : ?>
					<?php echo $this->load->view('admin/partials/filters') ?>
		
					<?php echo form_open('admin/blog/action') ?>
						<div id="filter-stage">
							<?php echo $this->load->view('admin/tables/posts') ?>
						</div>
					<?php echo form_close() ?>
				<?php else : ?>
					<div class="no_data"><?php echo lang('blog:currently_no_posts') ?></div>
				<?php endif ?>

		</section>

	</div>


</div>
</section>