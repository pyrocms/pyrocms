<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-GB">
	<head>
		<? $this->load->view($theme_view_folder.'metadata'); ?>
	</head>
	<body>
	
	<!-- CONTENT: Holds all site content except for the footer.  This is what causes the footer to stick to the bottom -->
	<div id="content">
	
	  <!-- HEADER: Holds title, subtitle and header images -->
	  <div id="header">
		<? $this->load->view($theme_view_folder.'header'); ?>	
	  </div>
	
	  <!-- MAIN MENU: Top horizontal menu of the site. -->
	  <? $this->load->view($theme_view_folder.'topnav'); ?>	
	
	  <!-- PAGE CONTENT BEGINS: This is where you would define the columns (number, width and alignment) -->
	  <div id="page">
	
	    <!-- Full width column, aligned to the right -->
	    <div class="fullColumn">
	
	        <a name="fluidity"></a>
	
	        <? if ($this->session->flashdata('notice')) {
		                  echo '<div class="notice-box">' . $this->session->flashdata('notice') . '</div>';
		    } ?>
		    <? if ($this->session->flashdata('success')) {
		                  echo '<div class="success-box">' . $this->session->flashdata('success') . '</div>';
		    } ?>
		    <? if ($this->session->flashdata('error')) {
		                  echo '<div class="error-box">' . $this->session->flashdata('error') . '</div>';
		    } ?>
		
	    	<?=$page_output; ?>
	
	    </div>
	
	  </div>
	</div>
	
	<!-- FOOTER: Site footer for links, copyright, etc. -->
	<div id="footer">
		<?$this->load->view($theme_view_folder.'footer'); ?>
	</div>
	
	</body>

</html>