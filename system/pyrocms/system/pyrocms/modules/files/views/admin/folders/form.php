<?php if (isset($messages['success'])): ?>
<script type="text/javascript">
(function($) {
	$(function() {
		parent.jQuery.colorbox.close();
		return false;
	});
})(jQuery);
</script>
<?php else: ?>

<?php echo form_open($this->uri->uri_string(), array('class' => 'crud', 'id' => 'folders_crud')); ?>
<h2><?php echo lang('files.folders.create'); ?></h2>
<ul>
	<li>
		<label for="name"><?php echo lang('files.folders.name'); ?></label>
		<?php echo form_input('name', $folder->name, 'class="required"'); ?>
	</li>
	<li>
		<label for="slug"><?php echo lang('files.folders.slug'); ?></label>
		<?php echo form_input('slug', $folder->slug, 'class="required"'); ?>
	</li>
	<li>
		<?php echo form_label(lang('files.labels.parent'). ':', 'parent_id'); ?>
		<?php
		$folder_options['0'] = lang('files.dropdown.no_subfolders');
		foreach($folder->parents as $row)
		{
			$indent = ($row['parent_id'] != 0) ? repeater('&nbsp;&raquo;&nbsp;', $row['depth']) : '';
			$folder_options[$row['id']] = $indent.$row['name'];
		}
		echo form_dropdown('parent_id', $folder_options, $folder->parent_id, 'id="parent_id" class="required"');
		?>
	</li>
	<li>
		<label for="nothing"></label>
		<?php echo form_submit('button_action', lang('buttons.save'), 'class="button"'); ?>
	</li>
</ul>

<?php echo form_close(); ?>

<?php endif; ?>