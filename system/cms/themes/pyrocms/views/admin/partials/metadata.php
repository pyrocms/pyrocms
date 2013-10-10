<?php //Asset::js(array()) ?>

<?php Asset::css(array('build.css')); ?>
<?php Asset::js(array('jquery.min.js', 'modernizr.min.js')); ?>


<?php if (isset($analytic_visits) OR isset($analytic_views)): ?>
	<?php //Asset::js('jquery/jquery.excanvas.min.js') ?>
	<?php //Asset::js('jquery/jquery.flot.js') ?>
<?php endif; ?>


<?php echo Asset::render() ?>

<!--[if lt IE 9]>
<?php echo Asset::css('ie.css', null, 'ie'); ?>
<?php echo Asset::render_css('ie'); ?>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php echo $template['metadata'] ?>
