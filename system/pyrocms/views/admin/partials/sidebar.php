<div class="box">
	<h3 class="yellow"><?php echo lang('sb_recent_users'); ?></h3>
	
	<div class="box-container">
		<ul class="list-links">
			<?php foreach($recent_users as $recent_user): ?>
			<li><?php echo anchor('admin/users/edit/' . $recent_user->id, $recent_user->full_name); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<?php if(!empty($recent_comments)): ?>
<div class="box">
	<h3 class="yellow"><?php echo lang('comments.recent_comments'); ?></h3>
	
	<div class="box-container">
	
		<?php foreach($recent_comments as $comment): ?>
			<p>
				<?php echo sprintf(lang('comments.list_comment'), $comment->name, $comment->item, date('d/m/Y', $comment->created_on)); ?>
				
				<br/><br/>
				
				<em>
					<?php echo anchor('admin/comments/preview/' . $comment->id, $comment->comment, 'rel="modal"'); ?>
				</em>
			</p>
			
			<hr />
		<?php endforeach; ?>
		
		<p class="float-right spacer-none">
			<?php echo anchor('admin/comments', lang('comments.view_more')); ?>
		</p>
		
		<br class="clear-both" />
	</div>
</div>
<?php endif;?>