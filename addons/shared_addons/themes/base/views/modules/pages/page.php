<style>
.cke_shared .cke_skin_pyroeditor {
  border-width: 0 0 1px 1px;
  float: left;
  min-width: 100%;
  outline: 0;
}

#inline-toolbar-wraper{
	text-align:center; position:fixed; top:0;left:0; margin:0; width:100%; z-index:9999; display:none;
}
#inline-toolbar{
	float: left;
	min-width: 85.5%;
	outline:0;
}

#inline-actions {
	float: right;
line-height: 27px;
min-height: 37px;
width: 11.5%;
background-color: #F5F5F5;
border: 1px solid rgba(150, 150, 150, 0.2);
outline:0;
padding: 9px;
display:none;
}
</style>
<article class="page">
	<?php echo $page->layout->body; ?>

	<?php if($page->comments_enabled): ?>
		<?php echo display_comments($page->id); ?>
	<?php endif; ?>
</article>
<?php if (isset($edit_mode) && group_has_role('pages', 'edit_live')): ?>
<script type="text/javascript">
	var APPPATH_URI = "<?php echo APPPATH_URI;?>";
	var BASE_URL = "<?php echo rtrim(site_url(), '/') . '/';?>";
	var SITE_URL = "<?php echo rtrim(site_url(), '/') . '/';?>";
	var BASE_URI = "<?php echo BASE_URI;?>";
	$(function(){
		$('.page-chunk').pyroEditor();
	});
</script>
<?php endif; ?>