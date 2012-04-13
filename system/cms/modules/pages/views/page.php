<!-- Page layout: <?php echo $page->layout->title; ?> -->
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
</script>
<?php endif; ?>