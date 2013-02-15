<!-- Install Complete -->
<section class="title">
<h3>{congrats}, {firstname} {lastname}!</h3>
</section>

<section class="item">
<p>{intro_text}</p>

<p>
	<strong><?php echo lang('email'); ?>:</strong> {email}
</p>
<p class="password-reveal">
	<strong><?php echo lang('password'); ?>:</strong> <span class="password">{password}</span>
</p>
<p><a class="button show-pass" href="#"> {show_password}</a></p>

<p><?php echo lang('outro_text'); ?></p>

<p>
	<?php echo anchor($website_url, lang('go_website'), 'class="button go_to_site"'); ?>
	<?php echo anchor($control_panel_url, lang('go_control_panel'), 'class="button go_to_site"'); ?>
</p>

<script>
	$(function(){
		$.get("<?php echo site_url('ajax/statistics');?>");
		$('.show-pass').click(function(e){
			e.preventDefault();
			$(this).fadeOut().parent().prev('.password-reveal').delay(400).fadeIn();
		});
	});
</script>

</section>
