<?php if (! isset($template['partials']['alternate_sections'])): ?>
<ul class="breadcrumb">
		
	<?php foreach ($module_details['sections'] as $name => $section): ?>
	<?php if(isset($section['name']) && isset($section['uri'])): ?>		

		<li class="<?php if ($name === $active_section) echo 'active' ?>">

			<?php if ($name === $active_section): ?>
				<strong>
					<a href="<?php echo site_url($section['uri']); ?>"><?php echo (lang($section['name']) ? lang($section['name']) : $section['name']); ?></a>
				</strong>
			<?php else: ?>
				<a href="<?php echo site_url($section['uri']); ?>"><?php echo (lang($section['name']) ? lang($section['name']) : $section['name']); ?></a>
			<?php endif; ?>

			<span class="divider">/</span>
		</li>

	<?php endif; ?>
	<?php endforeach; ?>

</ul>
<?php else: ?>
	<?php echo $template['partials']['alternate_sections']; ?>
<?php endif; ?>