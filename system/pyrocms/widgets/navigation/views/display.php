<?php function _render_nav($link_list, $level=0){ ?>

<ul class="<?php echo ($level > 0 ? 'navigation-level-'.$level : 'navigation'); ?>">
	<?php foreach( $link_list as $link): ?>
		<li<?php echo (current_url() == $link->url ? ' class="current"' : ''); ?>><?php echo anchor($link->url, $link->title, 'target="'.$link->target.'"');
		if(!empty($link->children))
		{
			_render_nav($link->children, $level+1);
		}
?>
</li>
	<?php endforeach; ?>
</ul>

<?php }

_render_nav(navigation_tree($group));
