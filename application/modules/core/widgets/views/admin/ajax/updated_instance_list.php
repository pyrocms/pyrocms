<table border="0" class="table-list">		    
	<thead>
		<tr>
			<th class="width-5"><?php echo form_checkbox('action_to_all');?></th>
			<th class="width-30">title</th>
			<th class="width-25">widget</th>
			<th class="width-10">stuff</th>
		</tr>
	</thead>
	<tbody>

	<?php foreach($widgets as $widget): ?>
	
		<tr>
			<td><?php echo form_checkbox('action_to[]', $widget->id); ?></td>
			<td><?php echo $widget->instance_title;?></td>
			<td><?php echo $widget->title;?></td>
			<td>
				<?php echo anchor('admin/navigation/edit/' . $widget->id, 'Edit');?> | 
				<?php echo anchor('admin/navigation/delete/' . $widget->id, 'Delete', array('class'=>'confirm'));?>
			</td>
		</tr>
	<?php endforeach; ?>
	
	</tbody>
</table>