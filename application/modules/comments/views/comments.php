<? $this->lang->module_load('comments', 'comments'); ?>
<? foreach($comments as $comment): ?>
	<? if(!empty($comments)): ?>
		<div>
			<p>
				<strong><?=lang('comments_posted_label');?>:</strong> <?= date('M d, Y', $comment->created_on); ?><br/>		
				<strong><?=lang('comments_from_label');?>:</strong> <?=$comment->name;?>
			</p>
			<p><?=stripslashes($comment->body);?></p>
			<hr/>
		</div>
	<? else: ?>
		<p><?=lang('comments_no_comments');?></p>
	<? endif; ?>
<? endforeach; ?>