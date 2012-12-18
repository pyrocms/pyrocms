<section class="title">
	<h4><?php echo $module_details['name'] ?></h4>
</section>

<section class="item">
	<div class="content">
		<?php if ($setting_sections): ?>
			<?php echo form_open('admin/settings/edit', 'class="crud"');?>
		
				<div class="tabs">
		
					<ul class="tab-menu">
						<?php foreach ($setting_sections as $section_slug => $section_name): ?>
						<li>
							<a href="#<?php echo $section_slug ?>" title="<?php printf(lang('settings:section_title'), $section_name) ?>">
								<span><?php echo $section_name ?></span>
							</a>
						</li>
						<?php endforeach ?>
					</ul>
		
					<?php foreach ($setting_sections as $section_slug => $section_name): ?>
					<div class="form_inputs" id="<?php echo $section_slug;?>">
						<fieldset>
							<ul>
							<?php $section_count = 1; foreach ($settings[$section_slug] as $setting): ?>
								<li id="<?php echo $setting->slug ?>" class="<?php echo $section_count++ % 2 == 0 ? 'even' : '' ?>">
									<label for="<?php echo $setting->slug ?>">
										<?php echo $setting->title ?>
										<?php if($setting->description): echo '<small>'.$setting->description.'</small>'; endif ?>
									</label>
		
									<div class="input <?php echo 'type-'.$setting->type ?>">
										<?php echo $setting->form_control ?>
									</div>
									<span class="move-handle"></span>
								</li>
							<?php endforeach ?>
							</ul>
						</fieldset>
					</div>
					<?php endforeach ?>
		
				</div>
		
				<div class="buttons padding-top">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )) ?>
				</div>
		
			<?php echo form_close() ?>
		<?php else: ?>
			<div>
				<p><?php echo lang('settings:no_settings');?></p>
			</div>
		<?php endif ?>
	</div>
</section>