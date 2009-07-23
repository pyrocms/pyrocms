<? $this->load->helper('typography'); ?>

<? if ($images): ?>
	<? foreach ($images as $image): ?>
		<div style="float:left; margin:0 20px 0 0">
			<a href="products/<?=$image->filename;?>" title="<?=$product->title;?>" rel="modal">
				<?=image('products/' . substr($image->filename, 0, -4) . '_thumb' . substr($image->filename, -4));?>
			</a>
		</div>
	<? endforeach; ?>
<? endif; ?>

<h2><?= $product->title; ?></h2>
<strong><?=lang('products_price_label');?>: <?= sprintf(lang('products_price_format'), $this->settings->item('currency'), $product->price); ?></strong>
<p><?= auto_typography($product->description); ?></p>