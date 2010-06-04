<div class="box" id="galleries_box">
	<h3>Galleries</h3>
	<div class="box-container">
		<?php echo form_open('admin/galleries/delete_gallery');?>		
		
		<?php if (!empty($galleries)): ?>
			<table border="0" class="table-list">			
				<thead>
					<tr>
						<th><?php echo form_checkbox('action_to_all');?></th>
						<th>Album</th>
						<th>Number of Photos</th>
						<th>Last Updated</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="5">
							<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>	
					<?php foreach( $galleries as $gallery ): ?>
					<tr>
						<td><?php echo form_checkbox('action_to[]', $gallery->id); ?></td>
						<td><?php echo $gallery->title; ?></td>
						<td><?php echo $gallery->photo_count; ?></td>
						<td><?php echo date('M d, Y',$gallery->updated_on); ?></td>
						<td>
							<?php echo
							anchor('galleries/' 						. $gallery->slug, 	'View', 'target="_blank"') 	. ' | ' .
							anchor('admin/galleries/manage/' 			. $gallery->id, 	'Manage') 					. ' | ' .
							anchor('admin/galleries/delete/'		 	. $gallery->id, 	'Delete', array('class'=>'confirm')); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>	
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		
		<?php else: ?>
			<p>No galleries have been created yet.</p>
		<?php endif;?>
		
		<?php echo form_close(); ?>
	</div>
</div>