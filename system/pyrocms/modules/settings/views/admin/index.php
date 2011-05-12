<style type="text/css">
	label { width: 23% !important; }
</style>

<?php echo form_open('admin/settings/edit', 'class="crud"');?>

	<!-- <h3><?php echo lang('settings_edit_title');?></h3> -->
	
	<div class="box-container">	
	
		<div class="tabs">
		
			<ul class="tab-menu">
				<?php foreach($setting_sections as $section_slug => $section_name): ?>
				<li><a href="#<?php echo $section_slug;?>" title="<?php if(lang('settings_section_'.$section_slug)!=''){echo lang('settings_section_'.$section_slug);}else{echo $section_name;}?> settings"><span><?php if(lang('settings_section_'.$section_slug)!=''){echo lang('settings_section_'.$section_slug);}else{echo $section_name;}?></span></a></li>
				<?php endforeach; ?>
			</ul>
			
			<?php foreach($setting_sections as $section_slug => $section_name): ?>		
			<div id="<?php echo $section_slug;?>">
			
				<fieldset>
					<ol>
					<?php $section_count = 1; foreach($settings[$section_slug] as $setting): ?>
						<li id="<?php echo $setting->slug; ?>" class="<?php echo $section_count++ % 2 == 0 ? 'even' : ''; ?>">
							<label for="<?php echo $setting->slug; ?>"><?php if(lang('settings_'.$setting->slug)!=''){echo lang('settings_'.$setting->slug);}else{echo $setting->title;}?></label>
							<div class="width-40 <?php echo 'type-' . $setting->type; ?>">
								<?php echo $setting->form_control; ?><br/>
								<div class="clear-both text-small1" style="margin-left: 160px;"><?php if(lang('settings_'.$setting->slug.'_desc')!=''){echo lang('settings_'.$setting->slug.'_desc');}else{echo $setting->description;} ?></div>
							</div>
							<br class="clear-both" />
							<span class="move-handle"></span>
						</li>
					<?php endforeach; ?>
					</ol>
					
				</fieldset>	
			</div>
			<?php endforeach; ?>		
			
		</div>
		
		<div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
		</div>
		
	</div>

<?php echo form_close(); ?>