<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	{theme_view('metadata')}

	{theme_css('messages.css')}
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
			<li>{anchor( $link->url, $link->title, array(target=$link->target))}</li>
		{/foreach}
	</ul>
	
	<div id="content">
	
			{if $ci->session->flashdata('notice')}
		    	<div class="notice-box">{$ci->session->flashdata('notice')}</div>
		    {/if}
		    {if $ci->session->flashdata('success')}
		    	<div class="success-box">{$ci->session->flashdata('success')}</div>
		    {/if}
		    {if $ci->session->flashdata('error')}
		    	<div class="error-box">{$ci->session->flashdata('error')}</div>
		    {/if}
			<div class="message_buttons">
				<span class="button_label">Go To:</span>
				{anchor('messages/inbox', lang('messages_inbox_title'))}
				{anchor('messages/sent', lang('messages_sent_title'))}
				{anchor('messages/trash', lang('messages_trash_title'))}
				<br clear="both" />
			</div>
		    {$template.body}
	    		
	</div>

	<!-- start footer -->
	<div id="footer">
		{theme_view('footer')}
	</div>
	<!-- end footer -->

</body>
</html>	