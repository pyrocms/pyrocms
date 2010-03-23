<h2><?php echo $newsletter->title; ?></h2>
<p>
	<em><?php echo lang('letter_created_on_label');?>: <?php echo date('M d, Y', $newsletter->created_on); ?></em>
  <?php if($newsletter->sent_on): ?>
    <br/>
    <em><?php echo lang('newsletter.sent');?>: <?php echo date('M d, Y', $newsletter->sent_on); ?></em>
  <?php endif; ?>
</p>    
<?php echo stripslashes($newsletter->body);?>