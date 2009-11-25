<p>
	<?php if(!empty($navigation['footer'])): 
		$last_link = array_pop($navigation['footer']);
		
		foreach($navigation['footer'] as $nav_link): ?>
			<?php echo anchor($nav_link->url, $nav_link->title); ?> | 
		<?php endforeach;
		
		echo anchor($last_link->url, $last_link->title);
	endif; ?>
	
<br />

&copy;2008 - <?php echo date('Y');?> by <?php echo $this->settings->item('site_name'); ?>. All Rights Reserved. &nbsp;&bull;&nbsp; Designed by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>

<?php // Google Tracker ?>
<?php if($this->settings->item('google_analytic')): ?>
	<?php $this->load->view('fragments/google_analytic'); ?>
<?php endif; ?>