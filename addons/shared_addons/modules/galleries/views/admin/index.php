<?php echo form_open('admin/galleries/delete');?>

<?php if ( ! empty($galleries)): ?>

	<table border="0" class="table-list">
		<thead>
			<tr>
				<th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th><?php echo lang('galleries.gallery_label'); ?></th>
				<th width="140"><?php echo lang('galleries.num_photos_label'); ?></th>
				<th width="140"><?php echo lang('galleries.updated_label'); ?></th>
				<th width="350" class="align-center"><?php echo lang('galleries.actions_label'); ?></th>
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
				<td><?php echo anchor('admin/galleries/preview/' . $gallery->id, $gallery->title, 'target="_blank" class="modal-large"'); ?></td>
				<td><?php echo $gallery->photo_count; ?></td>
				<td><?php echo format_date($gallery->updated_on); ?></td>
				<td class="align-center buttons buttons-small">
					<?php if ($gallery->folder_id && isset($folders[$gallery->folder_id]) && $path = $folders[$gallery->folder_id]->virtual_path): ?>
						<?php echo anchor('admin/files#!path='	. $path, 	lang('galleries.upload_label'), 'class="button"'); ?>
					<?php endif; ?>
					<?php echo anchor('admin/galleries/manage/'	. $gallery->id, 			lang('galleries.manage_label'), 'class="button"'); ?>
					<?php echo anchor('admin/galleries/delete/'	. $gallery->id, 			lang('galleries.delete_label'), array('class'=>'confirm button delete')); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
	</div>

<?php else: ?>
	<div class="blank-slate">
		<?php echo image('album.png', 'galleries', array('alt' => 'No Galleries')); ?>
		
		<h2><?php echo lang('galleries.no_galleries_error'); ?></h2>
	</div>
<?php endif;?>

<?php echo form_close(); ?>