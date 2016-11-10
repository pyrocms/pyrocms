<?php if ( ! empty($module_details['sections'][$active_section]['shortcuts']) ||  ! empty($module_details['shortcuts'])): ?>
<nav id="shortcuts" class="srt">
	<ul>
		<?php if ( ! empty($module_details['sections'][$active_section]['shortcuts'])): ?>
			<?php foreach ($module_details['sections'][$active_section]['shortcuts'] as $shortcut):
				$name 	= $shortcut['name'];
				$uri	= $shortcut['uri'];
				unset($shortcut['name']);
				unset($shortcut['uri']); ?>
			<li><a class="btn btn-info" style="margin-top: -5px; margin-right: 5px;"<?php foreach ($shortcut as $attr => $value) echo $attr.'="'.$value.'"'; echo 'href="' . site_url($uri) . '">' . lang($name) . '</a>'; ?></li>
			<?php endforeach; ?>
		<?php endif; ?>
		
		<?php if ( ! empty($module_details['shortcuts'])): ?>
			<?php foreach ($module_details['shortcuts'] as $shortcut):
				$name 	= $shortcut['name'];
				$uri	= $shortcut['uri'];
				unset($shortcut['name']);
				unset($shortcut['uri']); ?>
			<li><a  class="btn btn-info" style="margin-top: -5px; margin-right: 5px;"  <?php foreach ($shortcut as $attr => $value) echo $attr.'="'.$value.'"'; echo 'href="' . site_url($uri) . '">' . lang($name) . '</a>'; ?></li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
</nav>
<?php endif; ?>