<?php echo form_open('admin/settings/edit', 'class="crud"');?>

<div class="box">
	<h3><?php echo lang('settings_edit_title');?></h3>
	
	<div class="box-container">	
	
		<div class="tabs">
		
			<ul class="tab-menu">
				<?php foreach($setting_sections as $section_slug => $section_name): ?>
				<li><a href="#<?php echo $section_slug;?>" title="<?php echo $section_name;?> settings"><span><?php echo $section_name;?></span></a></li>
				<?php endforeach; ?>
			</ul>
			
			<?php foreach($setting_sections as $section_slug => $section_name): ?>		
			<div id="<?php echo $section_slug;?>">
			
				<fieldset>
					<ol>
						
					<?php $section_count = 1; foreach($settings[$section_slug] as $setting): ?>
						<li class="<?php echo $section_count % 2 == 0 ? 'even' : ''; ?>">
							<label for="<?php echo $setting->slug; ?>"><?php echo $setting->title; ?></label>
							<div class="float-right width-40">
								<?php echo $setting->form_control; ?><br/>
								<span class="clear-both text-small1"><?php echo $setting->description; ?></span>
							</div>
							
							<br class="clear-both" />
						</li>
					<?php ++$section_count; endforeach; ?>	
				
					</ol>
					
				</fieldset>	
			</div>
			<?php endforeach; ?>		
			
		</div>
		
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
		
	</div>
</div>

<?php echo form_close(); ?>