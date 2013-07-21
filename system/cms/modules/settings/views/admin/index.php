<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo $module_details['name'] ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php if ($setting_sections): ?>
				<?php echo form_open('admin/settings/edit', 'class="crud"');?>
			
					
					<!-- Tabs -->
					<ul class="nav nav-tabs padded no-padding-bottom grayLightest-bg">
						<?php foreach ($setting_sections as $section_slug => $section_name): ?>
						<li <?php echo current(array_keys($setting_sections)) == $section_slug ? 'class="active"' : null;?>>
							<a href="#<?php echo $section_slug ?>" title="<?php printf(lang('settings:section_title'), $section_name) ?>" data-toggle="tab">
								<span><?php echo $section_name ?></span>
							</a>
						</li>
						<?php endforeach ?>
					</ul>
					<!-- /Tabs -->

			
					<!-- Tab Content -->
					<div class="tab-content">

						<?php foreach ($setting_sections as $section_slug => $section_name): ?>
						<div class="tab-pane <?php echo current(array_keys($setting_sections)) == $section_slug ? 'active' : null;?>" id="<?php echo $section_slug;?>">
							<fieldset>
								<ul>
								<?php $section_count = 1; foreach ($settings[$section_slug] as $setting): ?>
									<li class="row-fluid input-row">
										<label class="span3" for="<?php echo $setting->slug ?>">
											<?php echo $setting->title ?>
											<?php if($setting->description): echo '<small>'.$setting->description.'</small>'; endif ?>
										</label>
			
										<div class="input span9 <?php echo 'type-'.$setting->type ?>">
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
					<!-- /Tab Content -->
			
					<div class="btn-group padded no-padding-bottom">
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )) ?>
					</div>
			
				<?php echo form_close() ?>
			<?php else: ?>
				<div>
					<p><?php echo lang('settings:no_settings');?></p>
				</div>
			<?php endif ?>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>