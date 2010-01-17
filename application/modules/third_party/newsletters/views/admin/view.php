<div class="box">
	
	<h3><?php echo $newsletter->title; ?></h3>
	
	<div class="box-container">
		<p>
			<em><?php echo lang('newsletter.created');?>: <?php echo date('M d, Y', $newsletter->created_on); ?></em>	
			<?php if($newsletter->sent_on): ?>
				<br />
				<em><?php echo lang('newsletter.sent');?>: <?php echo date('M d, Y', $newsletter->sent_on); ?></em>
			<?php endif; ?>
		</p>
		
		<hr />
		
		<?php echo $newsletter->body; ?>
	</div>
</div>