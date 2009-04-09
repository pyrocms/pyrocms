<table border="0" class="listTable">
    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Subject</a></th>
		<th><a href="#">Created</a></th>
		<th><a href="#">Date</a></th>
		<th class="last"><span>Actions</span></th>
	</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="5">
  			<div class="inner"></div>
  		</td>
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
			<td><em>Not sent</em></td>
			<? endif; ?>
	
			<td>
				<?=anchor('admin/newsletters/view/' . $newsletter->id, 'View'); ?>
				<? if($newsletter->sent_on == 0): ?>
				| <?=anchor('admin/newsletters/send/' . $newsletter->id, 'Send'); ?>
				<? endif; ?>
			</td>
		</tr>
		<? endforeach; ?>
	
		<? else: ?>
		<tr>
			<td colspan="5">There are no newsletters.</td>
		</tr>
		<? endif;?>
	</tbody>
</table>

<p class="float-left">
	<a href="<?=site_url('admin/newsletters/create'); ?>"><img src="/assets/img/admin/fcc/btn-new.jpg" /></a>
</p>

<p class="spacer-top float-right">
	Export Subscribers: [<?= anchor('admin/newsletters/export', 'XML'); ?>]
</p>