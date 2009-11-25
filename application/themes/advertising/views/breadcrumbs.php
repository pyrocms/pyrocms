<p>
	<small><?php echo anchor('', lang('breadcrumb_base_label')) ?>
	
	<?php foreach($breadcrumbs as $breadcrumb): ?>
		<?php if(!$breadcrumb['current_page']): ?>
		:: <?php echo anchor($breadcrumb['url_ref'], $breadcrumb['name']); ?>
		<?php else: ?>
		:: <?php echo $breadcrumb['name']; ?>
		<?php endif; ?>
	<?php endforeach; ?>
	</small>
</p>