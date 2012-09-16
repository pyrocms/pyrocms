<div class="one_full widget <?php echo $widget->slug ?>">

	<section class="draggable title">
		<?php if ($widget->options['show_title']): ?>
      <h4><?php echo $widget->instance_title; ?></h4>
    <?php endif; ?>
    <a class="tooltip-s toggle" title="Toggle this element"></a>
  </section>

	<section class="item">
		<?php echo $widget->body; ?>
  </section>

</div>