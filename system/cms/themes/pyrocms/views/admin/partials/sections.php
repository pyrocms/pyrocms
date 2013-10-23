<!--
/**
 * Sections
 */
-->	
<nav class="navbar-left" id="sections">

	<ul class="nav navbar-nav">
	<?php if (! empty($module_details['sections'])): ?>
		
		<?php foreach ($module_details['sections'] as $name => $section): ?>
		<?php if(isset($section['name']) && isset($section['uri'])): ?>
			<li class="<?php if ($name === $active_section) echo 'active' ?>">
				<?php echo anchor($section['uri'], (lang($section['name']) ? lang($section['name']) : $section['name']), 'data-hotkey="'.(array_search($section, array_values($module_details['sections']))+1).'"'); ?>
			</li>
		<?php endif; ?>
		<?php endforeach; ?>

	<?php elseif(! empty($module_details['name'])): ?>
		<li class="active">
			<?php echo anchor(site_url(uri_string()), $module_details['name'], 'data-hotkey="1"'); ?>
		</li>
	<?php endif; ?>
	</ul>

</nav>