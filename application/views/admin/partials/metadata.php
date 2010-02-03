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
<?php echo js('jquery/tabs.pack.js'); ?>

<?php echo js('jquery/jquery.fancybox.js').css('jquery/jquery.fancybox.css'); ?>
	
<?php echo $template['metadata']; ?>

<?php echo js('admin.js').css('admin/admin.css');?>