<?php echo css('jquery/jquery.treeview.css'); ?>
<?php echo js('jquery/jquery.treeview.min.js'); ?>
<?php echo js('index.js', 'pages'); ?>
<?php echo css('index.css', 'pages'); ?>

<p class="float-right">[ <?php echo anchor('admin/pages/layouts', lang('page_layouts_heading')); ?> ]</p>		

<br class="clear-both" />

<div id="page-tree" class="float-left" style="width:49%;">
	<ul class="filetree">
		<?php echo $page_tree_html; ?>  
	</ul>
</div>

<div id="page-details" class="float-right" style="width:45%;">

	<p>
		<?php echo lang('pages_tree_explanation'); ?>
	</p>

</div>

<br class="clear-both" />
