<table border="0" class="listTable">    
  <thead>
		<tr>
			<th class="first"><div></div></th>
			<th><a href="#"><?=lang('letter_subject_label');?></a></th>
			<th><a href="#"><?=lang('letter_created_label');?></a></th>
			<th><a href="#"><?=lang('letter_date_label');?></a></th>
			<th class="last"><span><?=lang('letter_actions_label');?></span></th>
		</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="5"><div class="inner"><? $this->load->view('admin/fragments/pagination'); ?></div></td>
  	</tr>
  </tfoot>	
	<tbody>
		<? if ($newsletters): ?>
			<? foreach ($newsletters as $newsletter): ?>
			<tr>
				<td><?=$newsletter->id; ?></td>
				<td><?=$newsletter->title; ?></td>
				<td><?=date('M d, Y', $newsletter->created_on); ?></td>	
				<? if($newsletter->sent_on > 0): ?>
					<td><?=date('M d, Y', $newsletter->sent_on);?></td>
				<? else: ?>
					<td><em><?=lang('letter_not_sent_label');?></em></td>
				<? endif; ?>	
				<td>
					<?=anchor('admin/newsletters/view/' . $newsletter->id, lang('letter_view_label')); ?>
					<? if($newsletter->sent_on == 0): ?>
					| <?=anchor('admin/newsletters/send/' . $newsletter->id, lang('letter_send_label')); ?>
					<? endif; ?>
				</td>
			</tr>
			<? endforeach; ?>	
		<? else: ?>
			<tr>
				<td colspan="5"><?=lang('letter_no_letters_error');?></td>
			</tr>
		<? endif;?>
	</tbody>
</table>

<p class="spacer-top float-right">
	<?=lang('letter_export_subscribers_label');?>: [<?= anchor('admin/newsletters/export', 'XML'); ?>]
</p>