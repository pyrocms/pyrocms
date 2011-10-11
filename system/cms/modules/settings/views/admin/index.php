<section class="title">
	<h4><?php echo lang('settings_edit_title');?></h4>
</section>

	<section class="item">
	<?php if ($setting_sections): ?>
		<?php echo form_open('admin/settings/edit', 'class="crud"');?>
	
			<div class="tabs">
	
				<ul class="tab-menu">
					<?php foreach ($setting_sections as $section_slug => $section_name): ?>
					<li>
						<a href="#<?php echo $section_slug; ?>" title="<?php printf(lang('settings_section_title'), $section_name); ?>">
							<span><?php echo $section_name; ?></span>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
	
				<?php foreach ($setting_sections as $section_slug => $section_name): ?>
				<div id="<?php echo $section_slug;?>">
					<fieldset>
						<ul>
						<?php $section_count = 1; foreach ($settings[$section_slug] as $setting): ?>
							<li id="<?php echo $setting->slug; ?>" class="<?php echo $section_count++ % 2 == 0 ? 'even' : ''; ?>">
								<label for="<?php echo $setting->slug; ?>">
									<?php echo $setting->title; ?>
								</label>

								<div class="<?php echo 'type-' . $setting->type; ?>">
									<?php echo $setting->form_control; ?><br/>
									<div>
										<?php echo $setting->description; ?>
									</div>
									<hr>
								</div>
								<br>
								<span class="move-handle"></span>
							</li>
						<?php endforeach; ?>
						</ul>
					</fieldset>
				</div>
				<?php endforeach; ?>
	
			</div>
	
			<div class="buttons float-right padding-top">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
			</div>
	
		<?php echo form_close(); ?>
	<?php else: ?>
		<div class="blank-slate">
			<h2><?php echo lang('settings_no_settings');?></h2>
		</div>
	<?php endif; ?>
</section>