<?php if( !empty($page->css) ): ?>
<style type="text/css">
	<?php echo $page->css; ?>
</style>
<?php endif; ?>

<h2><?php echo $page->title; ?></h2>

<?php echo stripslashes($page->body);?>