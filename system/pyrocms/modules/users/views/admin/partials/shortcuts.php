<nav id="shortcuts">
	<h6><?php echo lang('cp_shortcuts_title'); ?></h6>
	<ul>
		<li><?php echo anchor('admin/users/create', lang('user_add_title'), 'class="add"'); ?></li>
		<li>
			<a href="<?php echo site_url('admin/users');?>">
				<?php echo lang('user_active_title');?>
				<?php if($active_user_count > 0): ?><strong>(<?php echo $active_user_count ?>)</strong><?php endif; ?>
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('admin/users/inactive');?>">
				<?php echo lang('user_inactive_title');?>
				<?php if($inactive_user_count > 0): ?><strong>(<?php echo $inactive_user_count ?>)</strong><?php endif; ?>
			</a>
		</li>
	</ul>
	<br class="clear-both" />
</nav>