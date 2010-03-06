<?php echo form_open($form_action); ?>

	<div class="float-right spacer-right">
		<button type="submit">
			<span><?php echo $available ? 'Uninstall' : 'Install'  ?></span>
		</button>
	</div>

	<?php echo form_hidden('slug', $widget->slug); ?>

	<h2><?php echo $widget->title; ?></h2>
	
	<p><?php echo $widget->description; ?></p>
	
	<dl>
		<?php if(!empty($widget->author)): ?>
		<dt><?php echo lang('widgets.widget_author'); ?></dt>
		<dd>
			<?php if(!empty($widget->website)): ?>
				<?php echo anchor($widget->website, $widget->author); ?>
			<?php else: ?>
				<?php echo $widget->author; ?>
			<?php endif; ?>
		</dd>
		<?php endif; ?>
		
		<dt><?php echo lang('widgets.widget_short_name'); ?></dt>
		<dd><?php echo $widget->slug; ?></dd>
		
		<dt><?php echo lang('widgets.widget_version'); ?></dt>
		<dd><?php echo $widget->version; ?></dd>
	</dl>
	
<?php echo form_close(); ?>