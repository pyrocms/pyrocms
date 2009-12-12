<p>
	<?php foreach(navigation('footer') as $nav_link): ?>
		<span class="link"><?php echo anchor($nav_link->url, $nav_link->title); ?></span>
	<?php endforeach; ?>

	<br />
	
	&copy;2008 - <?php echo date('Y');?> by <?php echo $this->settings->item('site_name'); ?>. All Rights Reserved. &nbsp;&bull;&nbsp; Designed by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.
</p>

<?php // Google Tracker ?>
<?php if($this->settings->item('google_analytic')): ?>
	<?php $this->load->view('fragments/google_analytic'); ?>
<?php endif; ?>