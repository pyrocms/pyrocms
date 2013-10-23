<div class="p">

	<!-- .panel -->
	<section class="panel panel-default">

		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $module_details['name'] ?></h3>
		</div>

		
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


					<!-- .tab-content.panel-body -->
					<div class="tab-content panel-body">
					<?php foreach ($setting_sections as $section_slug => $section_name): ?>
						<div class="tab-pane <?php echo array_search($section_name, array_values($setting_sections)) == 0 ? 'active' : null; ?>" id="<?php echo $section_slug;?>">
							<?php $section_count = 1; foreach ($settings[$section_slug] as $setting): ?>
								<div class="form-group">
								<div class="row">
									
									<label class="col-lg-2" for="<?php echo $setting->slug ?>">
										<?php echo $setting->title ?>
										
										<?php if($setting->description): ?>
											<small class="help-block"><?php echo $setting->description; ?></small>
										<?php endif; ?>
									</label>

									<div class="col-lg-10">
										<?php echo $setting->form_control ?>
									</div>
								</div>
								</div>
							<?php endforeach ?>
						</div>
					<?php endforeach ?>
					</div>
					<!-- /.tab-content.panel-body -->


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


	</section>
	<!-- /.panel -->

</div>