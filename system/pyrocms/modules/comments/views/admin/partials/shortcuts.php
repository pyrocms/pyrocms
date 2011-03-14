<?php if($this->settings->moderate_comments): ?>
<nav id="shortcuts">
	<h6><?php echo lang('cp_shortcuts_title'); ?></h6>
	<ul>
		<li><?php echo anchor('admin/comments', lang('comments.list_title'))?></li>
	</ul>
	<br class="clear-both" />
</nav>
<?php endif; ?>