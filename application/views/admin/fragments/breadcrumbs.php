<p><?php echo anchor('admin', lang('cp_breadcrumb_home_title')) ?>	
	<?php foreach($breadcrumbs as $breadcrumb): ?>
		<?php if(!$breadcrumb['current_page']): ?>
		:: <?php echo anchor('admin/'.$breadcrumb['url_ref'], $breadcrumb['name']); ?>
		<?php else: ?>
		:: <?php echo $breadcrumb['name']; ?>
		<?php endif; ?>
	<?php endforeach; ?>	
</p>