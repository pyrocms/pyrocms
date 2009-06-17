<h2><?=lang('letter_letters_title');?></h2>

<? foreach($newsletters as $newsletter): ?>
<div class="articleHolder">
	<strong><?=  anchor('newsletters/archive/' . $newsletter->id, $newsletter->title); ?></strong>
	<em><?= date('d M y', $newsletter->created_on); ?></em>
	<div class="clear-both"></div>
</div>
<? endforeach; ?>