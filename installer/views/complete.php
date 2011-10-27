<!-- Install Complete -->
<h1>{congrats}, {user_firstname} {user_lastname}!</h1>

<p>{intro_text}</p>

<p>
	<strong>{email}:</strong> {user_email}<br />
	<strong>{password}:</strong> <span class="password">{user_password}</span> <a class="show-pass" href="#">{show_password}</a>
</p>

<p>{outro_text}</p>

<?php echo anchor($website_url, lang('go_website'), 'class="go_to_site"'); ?>
<?php echo anchor($control_panel_url, lang('go_control_panel'), 'class="go_to_site"'); ?>
<script>
	$(function(){
		$.get("<?php echo site_url('ajax/statistics');?>");
		$('.show-pass').click(function(e){
			e.preventDefault();
			$(this).fadeOut().prev('.password').delay(400).fadeIn();
		});
	});
</script>