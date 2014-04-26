<section class="title">
	<?php if(isset($template['page_title'])) { echo '<h4>'.lang_label($template['page_title']).'</h4>'; } ?>
</section>

<section class="item">
	<div class="content">
		<?php echo $content; ?>
	</div>
</section>