<!-- Install Complete -->
<h3>{congrats}, {user_firstname} {user_lastname}!</h3>

<p>{intro_text}</p>

<div class="block-message">
<p>
	<strong>{email}:</strong> {user_email}<br><br>
	
	<strong>{password}:</strong> <span class="password">{user_password}</span> <a class="button show-pass" href="#">{show_password}</a>
</p>

<p>{outro_text}</p>

<br><br>

<?php echo anchor($website_url, lang('go_website'), 'class="button go_to_site"'); ?>
<?php echo anchor($control_panel_url, lang('go_control_panel'), 'class="button go_to_site"'); ?>
<script>
	$(function(){
		$.get("<?php echo site_url('ajax/statistics');?>");
		$('.show-pass').click(function(e){
			e.preventDefault();
			$(this).fadeOut().prev('.password').delay(400).fadeIn();
		});
	});
</script>
</div>