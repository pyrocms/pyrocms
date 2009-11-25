<?php $this->load->helper('text'); ?>	
<h2 class="featured"><?php echo lang('products_title');?></h2>			
<?php if ($products): ?>
	<?php foreach ($products as $product) : ?>
		<?php $img = $images[$product->id]->filename; ?>
		<a href="<?php echo site_url('products/' . $product->id);?>">
			<?php echo image('products/' . substr($img, 0, -4) . '_home' . substr($img, -4));?>
		</a>		
		<h3><?php echo anchor('products/' . $product->id, $product->title); ?></h3>
		<p><?php echo word_limiter($product->description,50); ?></p>		
		<hr/>	
	<?php endforeach; ?>
<?php else: ?>
	<p><?php echo lang('products_no_products');?></p>
<?php endif; ?>