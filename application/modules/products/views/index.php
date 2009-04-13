<? $this->load->helper('text'); ?>
	
	<h2 class="featured">Products</h2>
			
    <? if ($products): ?>

	    <? foreach ($products as $product) : ?>
	        <a href="<?=site_url('products/' . $product->id);?>">
	        	<?=image('products/' . substr($images[$product->id]->filename, 0, -4) . '_home' . substr($images[$product->id]->filename, -4)); ?>
			</a>
			
	        <h3><?= anchor('products/' . $product->id, $product->title); ?></h3>
	        <p><?= word_limiter($product->description,50); ?></p>
			
			<hr/>
			
		<? endforeach; ?>

    <? else: ?>
		There are no products.
    <? endif; ?>