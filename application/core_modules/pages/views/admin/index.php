<?php echo css('jquery/jquery.treeview.css'); ?>
<?php echo js('jquery/jquery.treeview.min.js'); ?>
<?php echo js('index.js', 'pages'); ?>
<?php echo css('index.css', 'pages'); ?>

<div id="page-tree" class="float-left" style=" width:49%;">
	
	<?php echo $page_tree_html; ?>  

</div>

<div id="page-details" class="float-right" style="width:45%;">

	<p>
		<?php echo lang('pages_tree_explanation'); ?>
	</p>

</div>

<br class="clear-both" />
