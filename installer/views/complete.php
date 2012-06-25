<!-- Install Complete -->
<section class="title">
<h3>{congrats}, {user_firstname} {user_lastname}!</h3>
</section>

<section class="item">
<p>{intro_text}</p>

<div class="block-message">
<p>
	<strong>{email}:</strong> {user_email}
</p>
<p class="password-reveal">
	<strong>{password}:</strong> <span class="password">{user_password}</span>
</p>
<p><a class="button show-pass" href="#"> {show_password}</a></p>

<p>{outro_text}</p>

<hr>

<?php echo anchor($website_url, lang('go_website'), 'class="button go_to_site"'); ?>
<?php echo anchor($control_panel_url, lang('go_control_panel'), 'class="button go_to_site"'); ?>
<script>
	$(function(){
		$.get("<?php echo site_url('ajax/statistics');?>");
		$('.show-pass').click(function(e){
			e.preventDefault();
			$(this).fadeOut().parent().prev('.password-reveal').delay(400).fadeIn();
		});
	});
</script>
</div>

</section>
