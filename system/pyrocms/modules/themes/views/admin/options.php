<?php if ($options_array): ?>

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
	
	<div class="buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>
	
<?php echo form_close(); ?>

<?php else: ?>
	<div class="blank-slate">
		<h2><?php echo lang('themes.no_options'); ?></h2>
	</div>
<?php endif; ?>