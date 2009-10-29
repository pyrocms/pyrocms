<?php echo css('jquery/jquery.treeview.css'); ?>
<?php echo js('jquery/jquery.treeview.min.js'); ?>
<?php echo js('index.js', 'pages'); ?>
<?php echo css('index.css', 'pages'); ?>

<div id="page-tree" class="float-left" style=" width:49%;">
  
<? if (!empty($pages)): ?>

	<ul class="filetree">
 		<?php $this->load->view('admin/ajax/child_list'); ?>	
	</ul>
	
<? else: ?>
	<p><?php echo lang('page_no_pages');?></p>
<? endif; ?>

</div>

<div id="page-details" class="float-right" style="width:45%;">

	<p>
		<?php echo lang('pages_tree_explanation'); ?>
	</p>

</div>

<br class="clear-both" />