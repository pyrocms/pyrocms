<?php echo form_open(uri_string(), 'class="box-container crud"'); ?>

	<header><h3><?php echo $widget->title; ?></h3></header>

	<?php echo form_hidden('widget_id', $widget->id); ?>
	<?php echo isset($widget->instance_id) ? form_hidden('widget_instance_id', $widget->instance_id) : null; ?>
	<?php echo isset($error) && $error ? $error : null; ?>
	
	<div class="tabs">
		<ul class="tab-menu">
			<li><a href="#widget-content"><span><?php echo lang('widgets.content_label');?></span></a></li>
			<li><a href="#widget-context"><span><?php echo lang('widgets.context_label');?></span></a></li>
		</ul>
		
		<div class="form_inputs" id="widget-content">
			<fieldset>
				<ul>
					<li>
						<label><?php echo lang('widgets.instance_title'); ?>:
						<?php echo form_input('title', set_value('title', isset($widget->instance_title) ? $widget->instance_title : '')); ?>
						</label>
						<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
					</li>
			
					<li>
						<label><?php echo lang('widgets.show_title'); ?>:
						<?php echo form_checkbox('show_title', true, isset($widget->options['show_title']) ? $widget->options['show_title'] : false); ?>
						</label>
					</li>
			
					<?php if (isset($widget_areas)): ?>
					<li>
						<label><?php echo lang('widgets.widget_area'); ?>:
						<?php echo form_dropdown('widget_area_id', $widget_areas, $widget->widget_area_id); ?>
						</label>
					</li>
					<?php endif; ?>
				</ul>			
				<?php echo $form ? $form : null; ?>
			</fieldset>
		</div>
		
		<div class="form_inputs" id="widget-context">
			<fieldset>
				<ul>
					<li>
						<label for="hide"><input type="radio" id="hide" name="show_or_hide" value="0" <?php echo set_radio('show_or_hide', 0, ($widget->show_or_hide == 0) ? true : false); ?> /><?php echo lang('widgets.show:noton'); ?></label>
						<label for="show"><input type="radio" id="show" name="show_or_hide" value="1" <?php echo set_radio('show_or_hide', 1, ($widget->show_or_hide == 1) ? true : false); ?> /><?php echo lang('widgets.show:onlyon'); ?></label>
					</li>
					<li>
						<?php echo form_textarea('page_slugs', isset($widget->page_slugs) ? $widget->page_slugs : '', 'id="page_slugs"'); ?>
						<label for="page_slugs"><?php echo lang('widgets.show:directions'); ?></label>
					</li>
				</ul>
			</fieldset>
		</div>
	</div>
	
	<div id="instance-actions" class="align-right padding-bottom padding-right buttons buttons-small">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
	</div>
<?php echo form_close(); ?>