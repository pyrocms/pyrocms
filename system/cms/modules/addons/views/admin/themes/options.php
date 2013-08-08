<div class="one_full">
	<section class="title">
		<h4><?php echo lang('addons:themes:theme_label').' '.lang('addons:themes:options') ?></h4>
	</section>
	
	<section class="item">
		<div class="content">
			<?php if ($options_array): ?>
		
				<div class="padding-top">
					<?php echo form_open('admin/addons/themes/options/'.$slug, 'class="form_inputs options-form"');?>
					
						<?php echo form_hidden('slug', $slug) ?>
					
						<ul>
						<?php foreach($options_array as $option): ?>
							<li id="<?php echo $option->slug ?>" class="<?php echo alternator('even', '') ?>">
								<label for="<?php echo $option->slug ?>">
									<?php echo $option->title ?>
									<small><?php echo $option->description ?></small>
								</label>
								<div class="form_input <?php echo 'type-'.$option->type ?>">
									<?php echo $controller->form_control($option) ?>
								</div>
								<br class="clear-both" />
							</li>
						<?php endforeach ?>
						</ul>
						
						<div class="one_full">
							<div class="buttons alignleft">
								<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
							</div>
			
							<div class="buttons alignright">
								<?php $this->load->view('admin/partials/buttons', array('buttons' => array('re-index') )) ?>
							</div>
						</div>
						
					<?php echo form_close() ?>
				</div>
		
			<?php endif ?>
		</div>
	</section>
</div>

<script type="text/javascript">
	(function($) {
		$(function() {
			$('.colour-picker').miniColors({
				letterCase: 'uppercase',
			});
		});
	})(jQuery);
</script>