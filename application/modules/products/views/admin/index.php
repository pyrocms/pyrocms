<?php echo form_open('admin/products/delete');?>
	<table border="0" class="listTable">
		<thead>
		<tr>
			<th><?php echo form_checkbox('action_to_all');?></th>
			<th><a href="#"><?php echo lang('products_product_label');?></a></th>
			<th><a href="#"><?php echo lang('products_supplier_label');?></a></th>
			<th><a href="#"><?php echo lang('products_price_label');?></a></th>
			<th><a href="#"><?php echo lang('products_updated_label');?></a></th>
			<th><span><?php echo lang('products_actions_label');?></span></th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					<div class="inner"><?php $this->load->view('admin/fragments/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>			
		<tbody>
		<?php if ($products): ?>		
			<?php foreach ($products as $product): ?>
			<tr>
				<td><input type="checkbox" name="action_to[]" value="<?php echo $product->id; ?>" /></td>
				<td><?php echo anchor('admin/products/edit/' . $product->id, $product->title);?></td>
				<td>
					<?php if($product->supplier_title): ?>
						<?php echo anchor('admin/suppliers/edit/' . $product->supplier_slug, $product->supplier_title); ?>
					<?php endif; ?>
				</td>
				<td><?php echo sprintf(lang('products_price_format'), $this->settings->item('currency'), number_format($product->price, 2, '.', ','));?></td>
				<td><?php echo date('M d, Y', $product->updated_on); ?></td>
				<td>
					<?php echo anchor('products/' . $product->id, lang('products_view_label'), 'target="_blank"'); ?> | 
					<?php echo anchor('admin/products/photo/' . $product->id, lang('products_add_photo_label')); ?><br />
					<?php echo anchor('admin/products/edit/' . $product->id, lang('products_edit_label')); ?> | 
					<?php echo anchor('admin/products/delete/' . $product->id, lang('products_delete_label')); ?>
				</td>
			</tr>
			<?php endforeach; ?>		
		<?php else: ?>
			<tr>
				<td colspan="6"><?php echo lang('products_no_products');?></td>
			</tr>
		<?php endif; ?>
		</tbody>		
	</table>	
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close();?>