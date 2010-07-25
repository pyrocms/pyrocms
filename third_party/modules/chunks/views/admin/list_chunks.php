<div class="box">

	<h3><?php echo lang('chunks.list_chunks'); ?></h3>				
	
	<div class="box-container">	
	
		<?php if (!empty($chunks)): ?>
				
			<table border="0" class="table-list">    
				<thead>
					<tr>
						<th>Chunk Name</th>
						<th>Syntax</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="6">
							<div class="inner"></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($chunks as $chunk): ?>
						<tr>
							<td><?php echo $chunk->name; ?></td>
							<td>{$chunk.<?php echo $chunk->slug; ?>}</td>
							<td>
								<?php echo anchor('admin/form/edit_form/' . $chunk->id, 'Edit');?> | 
								<?php echo anchor('admin/form/delete_form/' . $chunk->id, 'Delete', array('class'=>'confirm')); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>	
			</table>
			
		<?php else: ?>
			<p><?php echo lang('chunks.no_chunks');?></p>
		<?php endif; ?>
	</div>
</div>
