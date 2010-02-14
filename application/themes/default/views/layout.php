<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	{theme_view('metadata')}
</head>

<body>

	{if $ci->settings->item('google_analytic')}
		{$ci->load->view('fragments/google_analytic')}
	{/if}
	
	<div id="header">
		{theme_view('header')}
	</div>
	
	<ul id="menu">
		{foreach navigation('header') link}
		<li>{anchor( $link->url, $link->title, array('target' => $link->target))}</li>
		{/foreach}
	</ul>
	
	<div id="content">
	
		<div id="left-column" class="sidebar">
			
			<div id="navigation">
				<h2>{lang('navigation_headline')}</h2>
				
				<ul class="spacer-left-dbl">
					{foreach navigation('sidebar') link}
					<li>{anchor( $link->url, $link->title, array('target' => $link->target))}</li>
					{/foreach}
				</ul>
				
			</div>
			
			{if(module_exists('newsletters')}
			<div id="subscribe_newsletter">
				{$ci->load->view('newsletters/subscribe_form')}
			</div>
			{/if}
	
			{if(module_exists('news')}
			<div id="recent-posts">
				<h2>Recent Posts</h2>
				{$ci->news_m->get_news_fragment()}
			</div>
			{/if}
			
		</div>


		<div id="right-column">
			
			{if $ci->session->flashdata('notice')}
		    	<div class="notice-box">{$ci->session->flashdata('notice')}</div>
		    {/if}
		    {if $ci->session->flashdata('success')}
		    	<div class="success-box">{$ci->session->flashdata('success')}</div>
		    {/if}
		    {if $ci->session->flashdata('error')}
		    	<div class="error-box">{$ci->session->flashdata('error')}</div>
		    {/if}
		
		    {$template.body}
	    		
		</div>
	
	</div>

	<!-- start footer -->
	<div id="footer">
		{theme_view('footer')}
	</div>
	<!-- end footer -->

</body>
</html>	