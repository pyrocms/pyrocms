<h2><?php echo lang('themes.theme_label') . ' ' . lang('themes.options'); ?></h2>
<?php if ($options_array): ?>

	<div class="padding-top">
		<?php echo form_open('admin/themes/options/' . $slug, 'class="crud options-form"');?>
		
			<?php echo form_hidden('slug', $slug); ?>
		
			<ol>
			<?php foreach($options_array as $option): ?>
				<li id="<?php echo $option->slug; ?>" class="<?php echo alternator('even', ''); ?>">
					<label for="<?php echo $option->slug; ?>"><?php echo $option->title; ?></label>
					<div class="width-40 <?php echo 'type-' . $option->type; ?>">
						<?php echo $controller->form_control($option); ?><br/>
						<div class="clear-both text-small1" style="margin-left: 160px;"><?php echo $option->description; ?></div>
					</div>
					<br class="clear-both" />
				</li>
			<?php endforeach; ?>
			</ol>
			
			<div class="buttons float-left padding-top">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('re-index') )); ?>
			</div>
			
			<div class="buttons float-right padding-top">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
			</div>
			
		<?php echo form_close(); ?>
	</div>

<?php else: ?>
	<div class="blank-slate">
		<h2><?php echo lang('themes.no_options'); ?></h2>
	</div>
<?php endif; ?>