<!-- Page layout: <?php echo $page->layout->title; ?> -->

<style>
#inline-actions {
float: right;
line-height: 36px;
min-height: 36px;
width: 11.38%;
background-color: #F5F5F5;
border: 1px solid rgba(150, 150, 150, 0.2);
outline: 3px solid rgba(0, 0, 0, 0.03);
padding: 10px;
}
</style>
<?php echo $page->layout->body; ?>

<?php if($page->comments_enabled): ?>
	<?php echo display_comments($page->id); ?>
<?php endif; ?>

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