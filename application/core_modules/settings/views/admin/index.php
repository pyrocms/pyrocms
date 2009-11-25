<?php echo form_open('admin/settings/edit');?>
<div class="fieldset fieldsetBlock active tabs">	
	<div class="header">
		<h3><?php echo lang('settings_edit_title');?></h3>
	</div>	
	<div class="tabs">
		<ul class="clear-both">
			<?php foreach($setting_sections as $section_slug => $section_name): ?>
			<li><a href="#<?php echo $section_slug;?>" title="<?php echo $section_name;?> settings"><span><?php echo $section_name;?></span></a></li>
			<?php endforeach; ?>
		</ul>		
		<?php foreach($setting_sections as $section_slug => $section_name): ?>		
		<fieldset id="<?php echo $section_slug;?>">
			<legend><?php echo $section_name;?></legend>		
			<?php $section_count = 1; foreach($settings[$section_slug] as $setting): ?>
			<div class="field">
					<label for="<?php echo $setting->slug; ?>"><?php echo $setting->title; ?></label>
					<div class="float-right width-40">
						<?php echo $setting->form_control; ?><br/>
						<span class="clear-both text-small1"><?php echo $setting->description; ?></span>
					</div>
			</div>
			<?php $section_count++; endforeach; ?>		
		</fieldset>
		<?php endforeach; ?>		
	</div>	
</div>			
<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save') )); ?>
<?php echo form_close(); ?>