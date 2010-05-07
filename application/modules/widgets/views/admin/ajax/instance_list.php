	<table border="0" class="table-list">		    
	<thead>
		<tr>
			<th class="width-5"><?php echo form_checkbox('action_to_all'); ?></th>
			<th class="width-5">#</th>
			<th class="width-30"><?php echo lang('widgets.instance_title'); ?></th>
			<th class="width-25"><?php echo lang('widgets.widget'); ?></th>
			<th class="width-25"><?php echo lang('widgets.tag_title'); ?></th>
			<th class="width-10">&nbsp;</th>
		</tr>
	</thead>
	<tbody>

	<?php foreach($widgets as $widget): ?>
	
		<tr id="instance-<?php echo $widget->id; ?>">
			<td><?php echo form_checkbox('action_to[]', $widget->id); ?></td>
			<td><?php echo $widget->instance_id;?></td>
			<td><?php echo $widget->instance_title;?></td>
			<td><?php echo $widget->title;?></td>
			<td><?php echo sprintf('{widget_instance(%s)}', $widget->id);?></td>
			<td>
				<a href="#" class="edit-instance"><?php echo lang('widgets.instance_edit'); ?></a> | 
				<a href="#" class="delete-instance"><?php echo lang('widgets.instance_delete'); ?></a>
			</td>
		</tr>
	<?php endforeach; ?>
	
	</tbody>
</table>