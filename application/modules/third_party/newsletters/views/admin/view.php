<h3><?php echo $newsletter->title; ?></h3>
<p>
	<em><?php echo lang('letter_created_on_label');?>: <?php echo date('M d, Y', $newsletter->created_on); ?></em>	
	<?php if($newsletter->sent_on): ?>
		<br />
		<em><?php echo lang('letter_sent_on_label');?>: <?php echo date('M d, Y', $newsletter->sent_on); ?></em>
	<?php endif; ?>
</p>
<p><?php echo $newsletter->body; ?></p>
<p><?php echo anchor('admin/newsletters/index', lang('letter_back_label'));?></p>
