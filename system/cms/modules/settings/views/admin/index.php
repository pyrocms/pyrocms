<!-- .panel -->
<section class="panel">

	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $module_details['name'] ?></h3>
	</div>

	<!-- .panel-content -->
	<div class="panel-content">

	
		<?php if ($setting_sections): ?>
			<?php echo form_open('admin/settings/edit', 'class="crud"');?>

				<div class="tabs">

					<ul class="nav nav-tabs">
						<?php foreach ($setting_sections as $section_slug => $section_name): ?>
						<li class="<?php echo array_search($section_name, array_values($setting_sections)) == 0 ? 'active' : null; ?>">
							<a href="#<?php echo $section_slug ?>" data-toggle="tab" title="<?php printf(lang('settings:section_title'), $section_name) ?>">
								<span><?php echo $section_name ?></span>
							</a>
						</li>
						<?php endforeach ?>
					</ul>

					<div class="tab-content panel">
					<?php foreach ($setting_sections as $section_slug => $section_name): ?>
					<div class="tab-pane <?php echo array_search($section_name, array_values($setting_sections)) == 0 ? 'active' : null; ?>" id="<?php echo $section_slug;?>">
						<div class="panel-heading">Panel heading for <?php echo $section_slug;?></div>
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
	<!-- /.panel-content -->

</section>
<!-- /.panel -->