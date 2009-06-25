<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view($theme_view_folder.'metadata'); ?>
</head>

<body>

	<div id="header">
		<? $this->load->view($theme_view_folder.'header'); ?>
	</div>
	
	<ul id="menu">
		<? if(!empty($navigation['header'])) foreach($navigation['header'] as $nav_link): ?>
		<li><?=anchor($nav_link->url, $nav_link->title); ?></li>
		<? endforeach; ?>
	</ul>
	
	<div id="content">

		<div id="full-column">
		
			<div class="breadcrumbs">
				<?$this->load->view($theme_view_folder.'breadcrumbs'); ?>
			</div>
		
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

	<!-- start footer -->
	<div id="footer">
		<? $this->load->view($theme_view_folder.'footer'); ?>
	</div>
	<!-- end footer -->

</body>
</html>	