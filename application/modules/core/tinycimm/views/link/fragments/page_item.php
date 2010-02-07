<li>
	<?php 
	$has_children = $controller->tinycimm_model->has_children($page->id);
	if ($has_children){?>
		<span class="hitarea hitarea-closed"></span>
	<?php } else {?>
		<span class="hitarea hitarea-disabled"></span>
	<?php }?>
	<a href="#page-<?php echo $page->id;?>" rel="page-<?php echo $page->id;?>" title="<?php echo $page->title;?>">
		<?php echo $page->title;?>
	</a>
	<?php if ($has_children) {
		echo $controller->link_manager_recurse_pages($page->id);
	}?>
</li>
