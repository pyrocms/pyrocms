<?php echo form_open('admin/galleries/delete');?>

<?php if ( ! empty($galleries)): ?>

	<table border="0" class="table-list">
		<thead>
			<tr>
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th><?php echo lang('galleries.album_label'); ?></th>
				<th><?php echo lang('galleries.num_photos_label'); ?></th>
				<th><?php echo lang('galleries.updated_label'); ?></th>
				<th><?php echo lang('galleries.actions_label'); ?></th>
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
					anchor('galleries/' 						. $gallery->slug, 	lang('galleries.view_label'), 'target="_blank"') 	. ' | ' .
					anchor('admin/galleries/manage/' 			. $gallery->id, 	lang('galleries.manage_label')) 					. ' | ' .
					anchor('admin/galleries/delete/'		 	. $gallery->id, 	lang('galleries.delete_label'), array('class'=>'confirm')); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>

<?php else: ?>
	<div class="blank-slate">
		<img src="<?php echo base_url().'addons/modules/galleries/img/album.png' ?>" />
		
		<h2><?php echo lang('galleries.no_galleries_error'); ?></h2>
	</div>
<?php endif;?>

<?php echo form_close(); ?>