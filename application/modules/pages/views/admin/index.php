<?php echo css('jquery/jquery.treeview.css'); ?>
<?php echo js('jquery/jquery.treeview.min.js'); ?>
<?php echo js('index.js', 'pages'); ?>
<?php echo css('index.css', 'pages'); ?>

<div id="page-tree" class="float-left" style="border:1px black solid; overflow:auto; width:49%; height:35em;">
  
<? if (!empty($pages)): ?>

	<ul class="filetree">
 		<?php $this->load->view('admin/ajax/child_list'); ?>	
	</ul>
	
<? else: ?>
	<p><?php echo lang('page_no_pages');?></p>
<? endif; ?>

</div>

<div id="page-details" class="float-right" style="border:1px black solid; width:45%; padding:1em">

	<p>
		The list on the left represents pages on your website. Click the "+" icon next to the page to show pages within it.
		When you click a page you will see all sorts of handy information in this box.
	</p>

</div>

<br class="clear-both" />