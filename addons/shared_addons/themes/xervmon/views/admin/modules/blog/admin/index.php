<div class="accordion-group ">
<div class="accordion-heading">
	 
		<h4><?php echo lang('blog:posts_title') ?></h4>
	</div>

<div class="accordion-body collapse in lstnav">
		<div class="content">
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
		</div>
	</div>
</div>
