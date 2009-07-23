
<p id="copyrights">Copyright 2009<?php if(date('Y') != '2009') {echo ' - '.date('Y');} ?> <?php echo $this->settings->item('site_name'); ?>, all rights reserved.</p><p id="site_notice">Site powered by PyroCMS</p>
    
<?php if($this->settings->item('google_analytic')): ?>
	<?php $this->load->view('fragments/google_analytic'); ?>
<?php endif; ?>