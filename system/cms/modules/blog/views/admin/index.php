
<section class="title">
	<h4><?php echo lang('blog_posts_title'); ?></h4>
</section>

<section class="item">

<?php if ($blog) : ?>

<?php echo $this->load->view('admin/partials/filters'); ?>

<div id="filter-stage">

	<?php echo form_open('admin/blog/action'); ?>

		<?php echo $this->load->view('admin/tables/posts'); ?>

	<?php echo form_close(); ?>
	
</div>

<?php else : ?>
	<div class="no_data"><?php echo lang('blog_currently_no_posts'); ?></div>
<?php endif; ?>

</section>
