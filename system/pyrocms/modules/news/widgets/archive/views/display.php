<?php if($archive_months): ?>
	<ul class="list-unstyled">
		<?php foreach($archive_months as $month): ?>
			<li>
				<a href="<?php echo site_url('news/archive/'.date('Y/m', $month->date));?>">
					<?php echo date("F 'y", $month->date) ?> (<?php echo $month->article_count; ?>)
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>