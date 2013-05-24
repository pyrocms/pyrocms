<section class="content-wrapper">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<span class="title"><?php echo $module_details['name'] ?></span>
		</section>
			
		<?php if ($setting_sections): ?>

			<?php echo form_open('admin/settings/edit', 'class="crud"');?>
		
				<ul class="nav nav-tabs form-nav-tabs no-padding-bottom bg grayLightest">
					<?php foreach ($setting_sections as $section_slug => $section_name): ?>
					<li class="<?php echo array_search($section_name, array_values($setting_sections)) == '0' ? 'active' : null; ?>">
						<a href="#<?php echo $section_slug ?>" data-toggle="tab" title="<?php printf(lang('settings:section_title'), $section_name) ?>">
							<span><?php echo $section_name ?></span>
						</a>
					</li>
					<?php endforeach ?>
				</ul>

				<div class="tab-content">
		
					<?php foreach ($setting_sections as $section_slug => $section_name): ?>
					<div class="tab-pane <?php echo array_search($section_name, array_values($setting_sections)) == '0' ? 'active' : null; ?>" id="<?php echo $section_slug;?>">
						
						<?php foreach ($settings[$section_slug] as $setting): ?>
							<div id="<?php echo $setting->slug ?>" class="row-fluid input-row">
								<label for="<?php echo $setting->slug ?>" class="span3">
									<?php echo $setting->title ?>
									<?php if($setting->description): echo '<small>'.$setting->description.'</small>'; endif ?>
								</label>
	
								<div class="input span9 <?php echo 'type-'.$setting->type ?>">
									<?php echo $setting->form_control ?>
								</div>
								<span class="move-handle"></span>
							</div>
						<?php endforeach ?>

					</div>
					<?php endforeach ?>
		
				</div>
		
				<div class="btn-group form-btn-group">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )) ?>
				</div>
		
			<?php echo form_close() ?>

		<?php else: ?>
			<div>
				<p><?php echo lang('settings:no_settings');?></p>
			</div>
		<?php endif ?>

	</section>


</div>
</section>