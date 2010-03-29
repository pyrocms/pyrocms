<div class="box">
	
	<h3><?php echo lang('newsletters.list_title'); ?></h3>
	
	<div class="box-container">
		<?php if (!empty($newsletters)): ?>
			<table border="0" class="table-list">    
			  <thead>
					<tr>
						<th></th>
						<th><?php echo lang('newsletter.subject');?></th>
						<th><?php echo lang('newsletter.created');?></th>
						<th><?php echo lang('newsletter.date');?></th>
						<th><span><?php echo lang('newsletter.actions');?></span></th>
					</tr>
			  </thead>
				<tbody>
					<?php foreach ($newsletters as $newsletter): ?>
					<tr>
						<td><?php echo $newsletter->id; ?></td>
						<td><?php echo $newsletter->title; ?></td>
						<td><?php echo date('M d, Y', $newsletter->created_on); ?></td>	
						<?php if($newsletter->sent_on > 0): ?>
							<td><?php echo date('M d, Y', $newsletter->sent_on);?></td>
						<?php else: ?>
							<td><em><?php echo lang('newsletter.not_sent_label');?></em></td>
						<?php endif; ?>	
						<td>
							<?php echo anchor('admin/newsletters/view/' . $newsletter->id, lang('newsletter.view')); ?>
							<?php if($newsletter->sent_on == 0): ?>
							| <?php echo anchor('admin/newsletters/send/' . $newsletter->id, lang('newsletters.send')); ?>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<p><?php echo lang('newsletter.no_newsletters_error');?></p>
		<?php endif;?>

		<p><?php $this->load->view('admin/partials/pagination'); ?></p>

	</div>
</div>