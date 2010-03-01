<div class="box">
	<h3 class="yellow"><?php echo lang('cp_sidebar_title')?></h3>
	
	<div class="box-container">
		<ul class="list-links">
			<li><?php echo anchor('admin/newsletters/create', lang('newsletters.add_title')) ?></li>
			<li><?php echo anchor('admin/newsletters', lang('newsletters.list_title')); ?></li>
		</ul>
	</div>
</div>

<div class="box">
	<h3><?php echo lang('newsletters.export_title')?></h3>
	
	<div class="box-container">
		<?php echo anchor('admin/newsletters/export', 'XML'); ?>
	</div>
</div>