<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-GB">
	<head>
		{theme_view('metadata')}
	</head>
	<body>
	
	{if $ci->settings->item('google_analytic')}
		{$ci->load->view('fragments/google_analytic')}
	{/if}
	
	<div id="content">
	
	  <div id="header">
		{theme_view('header')}
	  </div>
	
		{theme_view('topnav')}
	
	  <div id="page">
	
	    <div class="width-quater float-left leftColumn">
	
	        <div id="sideMenu">
				{theme_view('leftnav')}
			</div>
			
			{widget_area('sidebar')}
	
	    </div>
	

	    <div class="float-right rightColumn">
	
	        <a name="fluidity"></a>
	
	        <?php if ($this->session->flashdata('notice')): ?>
	        	<div class="notice-box"><?php echo $this->session->flashdata('notice'); ?></div>
		    <?php endif; ?>
	
	        <?php if ($this->session->flashdata('success')): ?>
	        	<div class="success-box"><?php echo $this->session->flashdata('success'); ?></div>
		    <?php endif; ?>
	
	        <?php if ($this->session->flashdata('error')): ?>
	        	<div class="error-box"><?php echo $this->session->flashdata('error'); ?></div>
		    <?php endif; ?>

		    {$template.body}
	
	    </div>
	
	  </div>
	</div>
	
	<div id="footer">
	    {theme_view('footer')}
	</div>
	
	</body>

</html>