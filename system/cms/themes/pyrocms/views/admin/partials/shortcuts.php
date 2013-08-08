<?php if ( ! empty($module_details['sections'][$active_section]['shortcuts']) ||  ! empty($module_details['shortcuts'])): ?>
<section id="shortcuts" class="pull-right">
	
	<?php if ( ! empty($module_details['sections'][$active_section]['shortcuts'])): ?>
		<?php foreach ($module_details['sections'][$active_section]['shortcuts'] as $shortcut):
			$name 	= $shortcut['name'];
			$uri	= $shortcut['uri'];
			$shortcut['class'] = isset($shortcut['class']) ? $shortcut['class'].' btn' : 'btn';
			unset($shortcut['name']);
			unset($shortcut['uri']); ?>
			<a <?php foreach ($shortcut as $attr => $value) echo $attr.'="'.$value.'"'; echo 'href="' . site_url($uri) . '">' . lang($name) . '</a>'; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	
	<?php if ( ! empty($module_details['shortcuts'])): ?>
		<?php foreach ($module_details['shortcuts'] as $shortcut):
			$name 	= $shortcut['name'];
			$uri	= $shortcut['uri'];
			$shortcut['class'] = isset($shortcut['class']) ? $shortcut['class'].' btn' : 'btn';
			unset($shortcut['name']);
			unset($shortcut['uri']); ?>
		<a <?php foreach ($shortcut as $attr => $value) echo $attr.'="'.$value.'"'; echo 'href="' . site_url($uri) . '">' . lang($name) . '</a>'; ?>
		<?php endforeach; ?>
	<?php endif; ?>

</section>
<?php endif; ?>