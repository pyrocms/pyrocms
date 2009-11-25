<h2><?php echo lang('supp_suppliers_title');?></h2>
<?php if ($suppliers): ?>
	<?php $this->load->helper('text'); ?>    
	<?php foreach ($suppliers as $supplier): ?>
		<?php echo  image('suppliers/' . $supplier->image, array('title'=>$supplier->title, 'class'=>'float-left spacer-right spacer-bottom')); ?>
		<h3><a href="<?php echo $supplier->url; ?>" target="_blank"><?php echo $supplier->title; ?></a></h3>
		<p><?php echo word_limiter($supplier->description,100); ?></p>
		<hr class="clear-both" />
	<?php endforeach; ?>
<?php else: ?>
	<p><?php echo lang('supp_no_suppliers');?></p>
<?php endif; ?>