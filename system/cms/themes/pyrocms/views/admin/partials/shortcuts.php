<?php if ( ! empty($module_details['sections'][$active_section]['shortcuts']) ||  ! empty($module_details['shortcuts'])): ?>
<div class="pull-left" id="shortcuts">
	<?php if ( ! empty($module_details['sections'][$active_section]['shortcuts'])): ?>
		<?php foreach ($module_details['sections'][$active_section]['shortcuts'] as $shortcut):
			$name 	= $shortcut['name'];
			$uri	= $shortcut['uri'];
			unset($shortcut['name'], $shortcut['uri']); ?>
		<a <?php foreach ($shortcut as $attr => $value) echo $attr.'="'.$value.'"'; echo 'href="' . site_url($uri) . '">' . lang($name); ?></a>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if ( ! empty($module_details['shortcuts'])): ?>
		<?php foreach ($module_details['shortcuts'] as $shortcut):
			$name 	= $shortcut['name'];
			$uri	= $shortcut['uri'];
			unset($shortcut['name'], $shortcut['uri']); ?>
		<a <?php foreach ($shortcut as $attr => $value) echo $attr.'="'.$value.'"'; echo 'href="' . site_url($uri) . '">' . lang($name); ?></a>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<?php endif;
