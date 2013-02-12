<div class="navbar sec" style="background: none repeat scroll 0% 0% white; margin-top: 39px; height: 37px; border-right-color: grey ! important; border-bottom-color: grey ! important; border-left-color: grey ! important; border-top: 0px none white;">
	<div class="container">
	
		<ul class="nav lst1">
			<?php foreach ($module_details['sections'] as $name => $section): ?>
			<?php if(isset($section['name']) && isset($section['uri'])): ?>
			<li class="<?php if ($name === $active_section) echo 'current' ?>">
				<?php echo anchor($section['uri'], (lang($section['name']) ? lang($section['name']) : $section['name'])); ?>
				<?php if ($name === $active_section): ?>
					<!-- <?php echo Asset::img('admin/section_arrow.png', ''); ?> -->
				<?php endif; ?>
			</li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>

	</div>
</div>
