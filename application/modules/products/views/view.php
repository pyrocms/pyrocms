
<? $this->load->helper('typography'); ?>

<? if ($images) { ?>

	 <? foreach ($images as $image) {
	 	echo '<div style="float:left; margin:0 20px 0 0"><a href="' .
	 	 base_url() . 'assets/img/products/' . $image->filename . '" title="' . 
	 	 $product->title . '" rel="lightbox">' . image('products/' . 
	 	 substr($image->filename, 0, -4) . '_thumb' . substr($image->filename, -4)) . '</a></div><p>';
	 }
	 ?>

<? } ?>

<h2><?= $product->title; ?></h2>
<strong>Price: <?= $this->settings->item('currency').$product->price; ?></strong>
<p><?= auto_typography($product->description); ?></p>
