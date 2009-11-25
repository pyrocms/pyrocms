<?php if( !empty($page->css) ): ?>
<style type="text/css">
	<?php echo $page->css; ?>
</style>
<?php endif; ?>

<!-- Page layout: <?php echo $page->layout->title ?> -->

<?php echo $page->layout->body; ?>