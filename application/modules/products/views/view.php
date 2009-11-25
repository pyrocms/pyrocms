<?php $this->load->helper('typography'); ?>

<?php if ($images): ?>
	<?php foreach ($images as $image): ?>
		<div style="float:left; margin:0 20px 0 0">
			<a href="products/<?php echo $image->filename;?>" title="<?php echo $product->title;?>" rel="modal">
				<?php echo image('products/' . substr($image->filename, 0, -4) . '_thumb' . substr($image->filename, -4));?>
			</a>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<h2><?php echo $product->title; ?></h2>
<strong><?php echo lang('products_price_label');?>: <?php echo sprintf(lang('products_price_format'), $this->settings->item('currency'), $product->price); ?></strong>
<p><?php echo auto_typography($product->description); ?></p>