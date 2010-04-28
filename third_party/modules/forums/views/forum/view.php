<div class="forum_buttons">
	<?php echo anchor('forums/topics/new_topic/'.$forum->id, ' New Topic ');?>
	<br clear="both" />
</div>
<?php echo $pagination['links']; ?>
<table class="forum_table" border="0" cellspacing="0">
	<thead>
		<tr>
			<th colspan="5" class="header"><?php echo $forum->title;?></th>
		</tr>
		<tr>
			<th width="2%">&nbsp;</th>
			<th width="53%">Topic Name</th>
			<th width="10%" class="center_col">Posts</th>
			<th width="10%" class="center_col">Views</th>
			<th width="25%">Last Post Info</th>
		</tr>
	</thead>
	
	<tbody>
  
		<?php if(empty($forum->topics)):?>
		<tr>
			<td colspan="5" align="center">There are no posts in this topic right now.</td>
		</tr>
	  
		<?php else: ?>
		  
		  <?php foreach($forum->topics as $topic): ?>
		  <tr>
			<td class="forum_icon">
				<?php echo $topic->sticky ? image('pin.png', 'forums') : image('folder.png', 'forums'); ?>
			</td>
			<td valign="top">
				<?php echo $topic->sticky ? '<span class="sticky">Sticky: </span>' : ''; ?>
				<strong><?php echo anchor('forums/topics/view/'.$topic->id, $topic->title);?></strong><br/>
				<span class="description">Author: <?php echo $this->users_m->get(array('id' => $topic->author_id))->full_name; ?></span>
			</td>
				<td class="center_col"><?php echo $topic->post_count;?></td>
				<td class="center_col"><?php echo $topic->view_count?></td>
				<td class="lastpost_info">
			<?php if(!empty($topic->last_post)):?>
			Posted: <?php echo anchor('forums/posts/view_reply/'.$topic->last_post->id, date('m.d.y g:i a', $topic->last_post->created_on)); ?><br/>
			Author: <?php echo $topic->last_post->author->full_name; ?>
			<?php endif;?>
			</td>
		  </tr>
		  <?php endforeach; ?>
  	</tbody>
  	
  <?php endif;?>
</table>
<?php echo $pagination['links']; ?>
<div class="forum_buttons">
	<?php echo anchor('forums/topics/new_topic/'.$forum->id, ' New Topic ');?>
	<br clear="both" />
</div>

