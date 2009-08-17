<? $this->lang->module_load('comments', 'comments'); ?>
<? if(!empty($comments)): ?>
	<? foreach($comments as $comment): ?>
	
		<div>
			<p>
				<strong><?=lang('comment_posted_label');?>:</strong> <?= date('M d, Y', $comment->created_on); ?><br/>		
				<strong><?=lang('comment_from_label');?>:</strong> <?=$comment->name;?>
			</p>
			<p><?=nl2br(stripslashes($comment->body));?></p>
			<hr/>
		</div>
	<? endforeach; ?>
<? else: ?>
	<p><?=lang('comments_no_comments');?></p>
<? endif; ?>
