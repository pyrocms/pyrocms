<div id="footer-top">

	<div class="float-left">
		<?php echo form_open($this->uri->uri_string(), 'id="change_language" method="get"'); ?>
			<label for="lang"><?php echo lang('cp_change_language'); ?></label>
			<?php //echo form_dropdown('lang', $language_options, CURRENT_LANGUAGE); ?>
			
			<select name="lang">
			<?php foreach($this->config->item('supported_languages') as $key => $lang): ?>
        		<option value="<?php echo $key; ?>" <?php echo CURRENT_LANGUAGE == $key ? 'selected="selected"' : ''; ?>>
        			<?php echo $lang['name']; ?>
        		</option>
        	<?php endforeach; ?>
        	</select>
        
		<?php echo form_close(); ?>
		
		<p>
			<?php echo anchor('http://pyrocms.com/documentation', lang('cp_documentation')); ?> | 
			<?php echo anchor('http://github.com/philsturgeon/pyrocms/issues', lang('cp_report_bug')); ?> | 
			<?php echo anchor('http://pyrocms.com/contact', lang('cp_contact_support')); ?>
		</p>
	</div>
	
	<div class="float-right">
		<h2><a href="http://pyrocms.com/" target="_blank">PyroCMS</a> v<?php echo CMS_VERSION;?></h2>
	</div>
	
	<span class="clearFix"></span>
</div>

<div id="footer-bottom">

	<p class="float-left">Theme by Onur Oztaskiran of <a href="http://www.monofactor.com">Monofactor</a>.</p>
	<p class="float-right">Copyright &copy; 2008 - <?php echo date('Y');?> <a href="http://philsturgeon.co.uk/" target="_blank">Phil Sturgeon</a></p>
	
</div>