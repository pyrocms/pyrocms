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
<?php echo validation_errors(); ?>
<?php if (isset($error)) echo $error; ?>
<?php echo form_open_multipart($this->uri->uri_string()); ?>
<h2><?php echo lang('files.upload.title'); ?></h2>
<ul>
	<li>
		<?php echo form_label(lang('files.folders.name'), 'name'); ?>
		<?php echo form_input('name', set_value('name', $name), 'class="crud"'); ?>
	</li>
	<li>
		<?php echo form_label(lang('files.description'), 'description'); ?><br />
		<?php
		$data = array(
		              'name'        => 'description',
		              'id'          => 'description',
		              'value'       => set_value('description', $description),
		              'rows'   		=> '4',
		              'cols'        => '50',
					  'class'		=> 'crud'
		            );
		?>
		<?php echo form_textarea($data); ?>
	</li>
	<li>
		<?php echo form_label(lang('files.labels.parent'). ':', 'folder_id'); ?>
		<?php 
		$folder_options['0'] = lang('files.dropdown.no_subfolders');
		foreach($folder->parents as $row)
		{
			$indent = ($row['parent_id'] != 0) ? repeater('&nbsp;&raquo;&nbsp;', $row['depth']) : '';
			$folder_options[$row['id']] = $indent.$row['name']; 
		}	
		echo form_dropdown('folder_id', $folder_options, $selected_id, 'id="folder_id" class="crud"');
		?>
	</li>
	<li>
		<?php echo form_label(lang('files.type'), 'type'); ?>
		<?php echo form_dropdown('type', $types, $type, 'id="type" class="crud"'); ?>
	</li>
	<li>
		<?php echo form_upload('userfile'); ?>
	</li>
	<li>
		<label for="nothing"></label>
		<?php echo form_submit('button_action', lang('buttons.save'), 'class="button"'); ?>
	</li>
</ul>

<?php echo form_close(); ?>

