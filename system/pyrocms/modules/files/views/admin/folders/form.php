<!-- TODO: Remove these styles for version 1.0 theme -->
<style type="text/css">
form ul {
	list-style: none;
}
form ul li {
	padding: 10px 0px;
}
form ul li label {
	display: inline-block;
	width: 70px;
	font-size: 14px;
}
form ul li input {
	width: 90%;
	border: 1px solid #DDDDDD;
	padding: 5px;
	font-size: 14px;
}

form ul li input.button {
	background: #666666;
	border: 1px solid #DDDDDD;
	color: #FFFFFF;
	font-size: 12px;
	width: auto;
	padding: 5px 15px;
	margin-right: 10px;
}
form ul li input.button:hover {
	background-color: #DDDDDD;
	border: 1px solid #CCCCCC;
	color: #333333;
}

</style>
<?php echo form_open($this->uri->uri_string()); ?>
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
		<?php echo form_submit('button_action', lang('buttons.cancel'), 'class="button"'); ?>
	</li>
</ul>

<?php echo form_close(); ?>

