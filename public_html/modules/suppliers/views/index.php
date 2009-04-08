<h2>Suppliers</h2>

<? if ($suppliers):
	$this->load->helper('text'); ?>
    
    <? foreach ($suppliers as $supplier): ?>
        <?=  image('suppliers/' . $supplier->image, array('title'=>$supplier->title, 'class'=>'float-left spacer-right spacer-bottom')); ?>

        <h3><a href="<?= $supplier->url; ?>" target="_blank"><?= $supplier->title; ?></a></h3>
          
        <p><?= word_limiter($supplier->description,100); ?></p>

		<hr class="clear-both" />
	
	<? endforeach; ?>

<? else: ?>
    <p>There are no suppliers.</p>
<? endif; ?>