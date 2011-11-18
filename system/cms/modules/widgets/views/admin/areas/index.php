<?php foreach ($widget_areas as $widget_area): ?>
	<section class="widget-area-box one_third" id="area-<?php echo $widget_area->slug; ?>" data-id="<?php echo $widget_area->id; ?>">
		<header>
			<h3><?php echo $widget_area->title; ?></h3>
		</header>
		<div class="widget-area-content accordion-content">
			<div class="area-buttons buttons buttons-small">
						
				<?php echo anchor('admin/'.$this->module_details['slug'].'/areas/edit/'.$widget_area->slug, lang('buttons.edit'), 'class="button edit"'); ?>
				<button type="submit" name="btnAction" value="delete" class="button delete confirm"><span>Delete</span></button>

			</div>

			<!-- Widget Area Tag -->
			<input type="text" class="widget-section-code widget-code" value='<?php echo sprintf('{{ widgets:area slug="%s" }}', $widget_area->slug); ?>' />

			<!-- Widget Area Instances -->
			<div class="widget-list">
				<?php $this->load->view('admin/instances/index', array('widgets' => $widget_area->widgets)); ?>
				<div style="clear:both"></div>
			</div>
		</div>
	</section>
<?php endforeach; ?>