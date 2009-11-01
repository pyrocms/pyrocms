<li>
	<?php 
	$hasChildren = $controller->tinycimm_model->hasChildren($page->id);
	if ($hasChildren){?>
		<span class="hitarea hitarea-closed"></span>
	<?php } else {?>
		<span class="hitarea hitarea-disabled"></span>
	<?php }?>
	<a href="#page-<?php echo $page->id;?>" rel="page-<?php echo $page->id;?>" title="<?php echo $page->title;?>">
		<?php echo $page->title;?>
	</a>
	<?php if ($hasChildren) {
		echo $controller->recurse_pages($page->id);
	}?>
</li>
