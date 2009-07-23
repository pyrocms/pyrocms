<?=form_open('admin/products/delete');?>
	<table border="0" class="listTable">
		<thead>
		<tr>
			<th class="first"><div></div></th>
			<th><a href="#"><?=lang('products_product_label');?></a></th>
			<th><a href="#"><?=lang('products_supplier_label');?></a></th>
			<th><a href="#"><?=lang('products_price_label');?></a></th>
			<th><a href="#"><?=lang('products_updated_label');?></a></th>
			<th class="last"><span><?=lang('products_actions_label');?></span></th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					<div class="inner"><? $this->load->view('admin/fragments/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>			
		<tbody>
		<? if ($products): ?>		
			<? foreach ($products as $product): ?>
			<tr>
				<td><input type="checkbox" name="action_to[]" value="<?= $product->id; ?>" /></td>
				<td><?= anchor('admin/products/edit/' . $product->id, $product->title);?></td>
				<td>
					<? if($product->supplier_title): ?>
						<?= anchor('admin/suppliers/edit/' . $product->supplier_slug, $product->supplier_title); ?>
					<? endif; ?>
				</td>
				<td><?=sprintf(lang('products_price_format'), $this->settings->item('currency'), number_format($product->price, 2, '.', ','));?></td>
				<td><?= date('M d, Y', $product->updated_on); ?></td>
				<td>
					<?= anchor('products/' . $product->id, lang('products_view_label'), 'target="_blank"'); ?> | 
					<?= anchor('admin/products/photo/' . $product->id, lang('products_add_photo_label')); ?><br />
					<?= anchor('admin/products/edit/' . $product->id, lang('products_edit_label')); ?> | 
					<?= anchor('admin/products/delete/' . $product->id, lang('products_delete_label')); ?>
				</td>
			</tr>
			<? endforeach; ?>		
		<? else: ?>
			<tr>
				<td colspan="6"><?=lang('products_no_products');?></td>
			</tr>
		<? endif; ?>
		</tbody>		
	</table>	
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?=form_close();?>