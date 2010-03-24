<div class="box">

	<h3><?php echo lang('photo_albums.list_title'); ?></h3>
	
	<div class="box-container">
			
		<?php echo form_open('admin/photos/delete');?>		
		
		<?php if (!empty($albums)): ?>	
			<table border="0" class="table-list">			
				<thead>
					<tr>
						<th><?php echo form_checkbox('action_to_all');?></th>
						<th><?php echo lang('photo_albums.album_label');?></th>
						<th><?php echo lang('photo_albums.number_of_photo_label');?></th>
						<th><?php echo lang('photo_albums.updated_label');?></th>
						<th><?php echo lang('photo_albums.actions_label');?></th>
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
					<?php function album_row($albums, $parent, $lvl) { ?>
					<?php if(isset($albums[$parent])) foreach ($albums[$parent] as $album): ?>
						<tr>
							<td><?php echo form_checkbox('action_to[]', $album->id); ?></td>
			        <td><?php echo repeater('-- ', $lvl);?> <?php echo $album->title;?></td>
			        <td><?php echo $album->num_photos;?></td>
			        <td><?php echo date('M d, Y', $album->updated_on);?></td>
			        <td><?php echo anchor('photos/' . $album->slug, lang('photo_albums.view_label'), 'target="_blank"') . ' | ' .
									anchor('admin/photos/manage/' . $album->id, lang('photo_albums.manage_label')) . ' | ' .
									anchor('admin/photos/edit/' . $album->id, lang('photo_albums.edit_label')) . ' | ' .
									anchor('admin/photos/delete/' . $album->id, lang('photo_albums.delete_label'), array('class'=>'confirm')); ?>
			        </td>
			      </tr>
			      <?php album_row($albums, $album->id, $lvl+1) ?>
			      <?php endforeach; }?>            
				  <?php album_row($albums, 0, 0); ?>
				</tbody>
			</table>	
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		
		<?php else: ?>
			<p><?php echo lang('photo_albums.no_albums_error');?></p>
		<?php endif;?>
		
		<?php echo form_close(); ?>
	</div>
</div>