<?php if($display_by == 'month') : ?>
	<?php if($archive_months): ?>
		<ul class="list-unstyled">
			<?php foreach($archive_months as $month): ?>
				<li>
					<a href="<?php echo site_url('blog/archive/'.date('Y/m', $month->date));?>">
						<?php echo format_date($month->date, lang('blog_archive_date_format')) ?> (<?php echo $month->post_count; ?>)
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
<?php elseif($display_by == 'year') : ?>
	<?php if($archive_years): ?>
		<ul class="list-unstyled">
			<?php foreach($archive_years as $year): ?>
				<li>
					<a href="<?php echo site_url('blog/archive/'.$year->date);?>">
						<?php echo $year->date ?> (<?php echo $year->post_count; ?>)
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
<?php endif; ?>