<div class="box">
	<h3 class="yellow"><?php echo lang('cp_sidebar_title')?></h3>
	
	<div class="box-container">
		<ul class="list-links">
			<li><?php echo anchor('admin/users/create', lang('user_add_title')); ?></li>
			<li>
				<a href="<?php echo site_url('admin/users');?>" class="ajax">
					<?php echo lang('user_active_title');?>
					<?php if($active_user_count > 0): ?><strong>(<?php echo $active_user_count ?>)</strong><?php endif; ?>
				</a>
			</li>
			<li>
				<a href="<?php echo site_url('admin/users/inactive');?>" class="ajax">
					<?php echo lang('user_inactive_title');?>
					<?php if($inactive_user_count > 0): ?><strong>(<?php echo $inactive_user_count ?>)</strong><?php endif; ?>
				</a>
			</li>
		</ul>
	</div>
</div>