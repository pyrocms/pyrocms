<? $this->load->helper('text'); ?>	
<h2 class="featured"><?=lang('products_title');?></h2>			
<? if ($products): ?>
	<? foreach ($products as $product) : ?>
		<? $img = $images[$product->id]->filename; ?>
		<a href="<?=site_url('products/' . $product->id);?>">
			<?=image('products/' . substr($img, 0, -4) . '_home' . substr($img, -4));?>
		</a>		
		<h3><?= anchor('products/' . $product->id, $product->title); ?></h3>
		<p><?= word_limiter($product->description,50); ?></p>		
		<hr/>	
	<? endforeach; ?>
<? else: ?>
	<p><?=lang('products_no_products');?></p>
<? endif; ?>