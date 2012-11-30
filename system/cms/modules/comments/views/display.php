<?php if ($comments): ?>
	
	<?php foreach ($comments as $item): ?>
		
		<div class="comment">
			<div class="image">
				<?php echo gravatar($item->user_email, 60) ?>
			</div>
			<div class="details">
				<div class="name">
					<?php if ($item->user_id): ?>
						<?php echo anchor($item->website ? $item->website : 'user/'.$item->username, $item->display_name); ?>
					<?php else: ?>
						<?php echo $item->website ? anchor($item->website, $item->user_name, 'rel="external nofollow"') : $item->user_name ?>
					<?php endif; ?>
				</div>
				<div class="date">
					<p><?php echo format_date($item->created_on); ?></p>
				</div>
				<div class="content">
					<?php if (Settings::get('comment_markdown') and $item->parsed): ?>
						<?php echo $item->parsed; ?>
					<?php else: ?>
						<p><?php echo nl2br($item->comment) ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div><!-- close .comment -->
	<?php endforeach; ?>
	
<?php else: ?>
	<p><?php echo lang('comments:no_comments'); ?></p>
<?php endif ?>