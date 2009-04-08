<h3><?= $newsletter->title; ?></h3>

<p>
	<em>Created On: <?= date('M d, Y', $newsletter->created_on); ?></em>
	
	<? if($newsletter->sent_on): ?> <br />
	<em>Sent On: <?= date('M d, Y', $newsletter->created_on); ?></em> <? endif; ?>
</p>

<p><?= $newsletter->body; ?></p>

<p><?=anchor('admin/newsletters/index', 'Back');?></p>
