<table border="0" class="table-list long">    
  <thead>
		<tr>
			<th></th>
			<th><a href="#"><?php echo lang('letter_subject_label');?></a></th>
			<th><a href="#"><?php echo lang('letter_created_label');?></a></th>
			<th><a href="#"><?php echo lang('letter_date_label');?></a></th>
			<th><span><?php echo lang('letter_actions_label');?></span></th>
		</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="5"><div class="inner"><?php $this->load->view('admin/fragments/pagination'); ?></div></td>
  	</tr>
  </tfoot>	
	<tbody>
		<?php if ($newsletters): ?>
			<?php foreach ($newsletters as $newsletter): ?>
			<tr>
				<td><?php echo $newsletter->id; ?></td>
				<td><?php echo $newsletter->title; ?></td>
				<td><?php echo date('M d, Y', $newsletter->created_on); ?></td>	
				<?php if($newsletter->sent_on > 0): ?>
					<td><?php echo date('M d, Y', $newsletter->sent_on);?></td>
				<?php else: ?>
					<td><em><?php echo lang('letter_not_sent_label');?></em></td>
				<?php endif; ?>	
				<td>
					<?php echo anchor('admin/newsletters/view/' . $newsletter->id, lang('letter_view_label')); ?>
					<?php if($newsletter->sent_on == 0): ?>
					| <?php echo anchor('admin/newsletters/send/' . $newsletter->id, lang('letter_send_label')); ?>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>	
		<?php else: ?>
			<tr>
				<td colspan="5"><?php echo lang('letter_no_letters_error');?></td>
			</tr>
		<?php endif;?>
	</tbody>
</table>

<p class="spacer-top float-right">
	<?php echo lang('letter_export_subscribers_label');?>: [<?php echo anchor('admin/newsletters/export', 'XML'); ?>]
</p>