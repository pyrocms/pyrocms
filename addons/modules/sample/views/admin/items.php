<?php echo form_open('admin/sample/delete_item');?>

<?php if (!empty($items)): ?>
	<h3><?php echo lang('sample.item_list'); ?></h3>

	<table border="0" class="table-list">
		<thead>
			<tr>
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th><?php echo lang('sample.name'); ?></th>
				<th><?php echo lang('sample.slug'); ?></th>
				<th><?php echo lang('sample.manage'); ?></th>
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
			<?php foreach( $items as $item ): ?>
			<tr>
				<td><?php echo form_checkbox('action_to[]', $item->id); ?></td>
				<td><?php echo $item->name; ?></td>
				<td><a href="<?php echo rtrim(site_url(), '/').'/sample'; ?>">
					<?php echo rtrim(site_url(), '/').'/sample'; ?></a></td>
				<td>
					<?php echo
					anchor('sample', 	lang('sample.view'), 'target="_blank"') 	. ' | ' .
					anchor('admin/sample/edit_item/'		. $item->id, 	lang('sample.edit')) 					. ' | ' .
					anchor('admin/sample/delete_item/' 	. $item->id, 	lang('sample.delete'), array('class'=>'confirm')); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>

<?php else: ?>
	<div class="blank-slate">
		<img src="<?php echo site_url('addons/modules/sample/img/album.png') ?>" />
		
		<h2><?php echo lang('sample.no_items'); ?></h2>
	</div>
<?php endif;?>

<?php echo form_close(); ?>