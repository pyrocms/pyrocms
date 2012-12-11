<div class="widget <?php echo $widget->slug ?>">
	<?php if ($widget->options['show_title']): ?>
		<h3><?php echo $widget->instance_title ?></h3>
	<?php endif ?>

	<?php echo $widget->body ?>
	<div class="divider"></div>
</div>