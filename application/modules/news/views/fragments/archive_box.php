<? if($archive_months): ?>
	<p><strong><?=lang('news_archive_title');?></strong></p>	
	<ul class="list-unstyled">
		<? foreach($archive_months as $month): ?>
			<li>
				<a href="<?=site_url('news/archive/'.date('Y/m', $month->date));?>">
					<?=date("F 'y", $month->date) ?> (<?=$month->article_count; ?>)
				</a>
			</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>