<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	{theme_view('metadata')}
</head>
<body>

{if $ci->settings->item('google_analytic')}
	{$ci->load->view('fragments/google_analytic')}
{/if}
	
<div id="wrapper">
	<div id="header">
		<div id="logo">
			{theme_view('header')}
		</div>
	</div>
	<!-- end #header -->
	<div id="menu">
		{theme_view('topnav')}
	</div>
	<!-- end #menu -->
	<div id="page">
		<div id="content">
				{if $ci->session->flashdata('notice')}
					<div class="notice-box">{$this->session->flashdata('notice')}</div>
				{/if}

				{if $ci->session->flashdata('success')}
					<div class="success-box">{$this->session->flashdata('success')}</div>
				{/if}

				{if $this->session->flashdata('error')}
					<div class="error-box">{$this->session->flashdata('error')}</div>
				{/if}

				{$template.body}
			<div style="clear: both;">&nbsp;</div>
		</div>
		<!-- end #content -->
		<div id="sidebar">
			{theme_view('leftnav')}
			
			{widget_area('sidebar')}
		</div>
		<!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end #page -->
</div>
<div id="footer-content">
	<div class="column1">
		{theme_view('topcontrol')}
	</div>
	<div class="column2">
		<br />
		{foreach(navigation('footer') nav_link)}
			{anchor($nav_link->url, $nav_link->title)}<br />
		{/foreach}
	</div>
</div>
<div id="footer">
	<p> {theme_view('footer')} </p>
</div>
<!-- end #footer -->
</body>
</html>