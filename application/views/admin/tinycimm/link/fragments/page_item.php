<li>
	<a href="#page-<?php echo $page->id;?>" rel="page-<?php echo $page->id;?>">
		<?php echo $page->title;?>
	</a>

	<?php if ($controller->tinycimm_model->hasChildren($page->id)) {
		echo $controller->recurse_pages($page->id);
	}?>
</li>
