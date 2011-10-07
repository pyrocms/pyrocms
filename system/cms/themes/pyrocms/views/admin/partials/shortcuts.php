<nav id="shortcuts">
	<ul>
		<?php if ( ! empty($module_details['sections'][$active_section]['shortcuts'])): ?>
			<?php foreach ($module_details['sections'][$active_section]['shortcuts'] as $shortcut): ?>
			<li><?php echo anchor($shortcut['uri'], lang($shortcut['name'])); ?></li>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php if ( ! empty($module_details['shortcuts'])): ?>
			<?php foreach ($module_details['shortcuts'] as $shortcut): ?>
			<li><?php echo anchor($shortcut['uri'], lang($shortcut['name'])); ?></li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
</nav>