<h2><?= $newsletter->title; ?></h2>
<p>
	<em><?=lang('letter_created_on_label');?>: <?= date('M d, Y', $newsletter->created_on); ?></em>
  <? if($newsletter->sent_on): ?>
    <br/>
    <em><?=lang('letter_sent_on_label');?>: <?= date('M d, Y', $newsletter->sent_on); ?></em>
  <? endif; ?>
</p>    
<?=stripslashes($newsletter->body);?>