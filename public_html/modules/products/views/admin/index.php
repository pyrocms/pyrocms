<?=form_open('admin/products/delete');?>

<table border="0" class="listTable">
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Product</a></th>
		<th><a href="#">Supplier</a></th>
		<th><a href="#">Price</a></th>
		<th><a href="#">Updated</a></th>
		<th class="last"><span>Actions</span></th>
	</tr>
  </thead>
	  
	<tbody>
	<? if ($products): ?>
	
		<? foreach ($products as $product): ?>
		<tr>
			<td><input type="checkbox" name="delete[<?= $product->id; ?>]" /></td>
			<td><?= anchor('admin/products/edit/' . $product->id, $product->title);?></td>
			<td><?= anchor('admin/suppliers/edit/' . $product->supplier_slug, $product->supplier_title); ?></td>
			<td><?= $this->settings->item('currency') . number_format($product->price, 2, '.', ','); ?></td>
			<td><?= date('M d, Y', $product->updated_on); ?></td>
			<td>
				<?= anchor('products/' . $product->id, 'View', 'target="_blank"'); ?> | 
				<?= anchor('admin/products/photo/' . $product->id, 'Add Photo'); ?> | 
				<?= anchor('admin/products/edit/' . $product->id, 'Edit'); ?>
			</td>
		</tr>
		<? endforeach; ?>
	
	<? else: ?>
		<tr>
			<td colspan="6">There are no Products.</td>
		</tr>
	<? endif; ?>
	</tbody>
	
</table>

<p>
	<a href="<?=site_url('admin/products/create');?>"><img src="/assets/img/admin/fcc/btn-new.jpg" alt="New" title="New" /></a>
	<input type="image" src="/assets/img/admin/fcc/btn-delete.jpg" alt="Delete" name="btnDelete" value="Delete" />
</p>
<?=form_close();?>