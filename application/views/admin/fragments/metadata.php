<script type="text/javascript">
    var APPPATH_URI = "<?php echo $this->config->item('asset_dir');?>";
    var BASE_URL = "<?php echo base_url();?>";
    var BASE_URI = "<?php echo BASE_URI;?>";
    var DEFAULT_TITLE = "<?php echo $this->settings->item('site_name'); ?>";
</script>
        
<?php echo js('jquery/jquery.js'); ?>
<?php echo js('jquery/jquery-ui.min.js'); ?>

<script type="text/javascript">
    jQuery.noConflict();
</script>

<?php echo js('jquery/jquery.dimensions.js'); ?>
<?php echo js('jquery/jquery.imgareaselect.js'); ?>
<?php echo js('jquery/jquery.simplemodal.js').css('jquery/confirm.css'); ?>
<?php echo js('jquery/jquery.tooltip.min.js'); ?>
<?php echo js('jquery/jquery.tablesorter.min.js'); ?>

<? /* Added for Ajaxify */ ?>
<?php echo js('jquery/jquery.livequery.pack.js'); ?>
<?php echo js('jquery/jquery.ajaxify.js'); ?>
<?php echo js('jquery/jquery.history.fixed.js'); ?>
<?php echo js('jquery/jquery.metadata.min.js'); ?>

<?php echo js('facebox.js').css('facebox.css'); ?>
	
<?php echo $extra_head_content; ?>        
<?php echo js('functions.js'); ?>
<?php echo js('admin.js').css('admin/admin.css');?>

<?php echo css('admin/orange.css'); ?>    