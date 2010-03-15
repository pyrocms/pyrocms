<?php echo anchor('forums/topics/new_topic/'.$forum->id, ' New Topic ');?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
	<thead>
		<tr>
			<th colspan="5" scope="col"><?php echo $forum->title;?></th>
		</tr>
		<tr>
			<td width="5%">&nbsp;</td>
			<td width="45%">Topic Name</td>
			<td width="10%">Posts</td>
			<td width="10%">Views</td>
			<td width="30%">Last Post Info</td>
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
			<td></td>
			<td valign="top">
				<strong><?php echo anchor('forums/topics/view/'.$topic->id, $topic->title);?></strong><br/>
				Author: <?php echo $this->users_m->get(array('id' => $topic->author_id))->full_name; ?>
			</td>
				<td align="center" valign="middle"><?php echo $topic->post_count;?></td>
				<td align="center" valign="middle"><?php echo $topic->view_count?></td>
				<td>
			<?php if(!empty($topic->last_post)):?>
			Posted: <?php echo anchor('forums/posts/view_reply/'.$topic->last_post->id, date('d M y', $topic->last_post->created_on)); ?><br/>
			Author: <?php echo $this->users_m->get(array('id' => $forum->last_post->author_id))->full_name; ?>
			<?php endif;?>
			</td>
		  </tr>
		  <?php endforeach; ?>
  	</tbody>
  	
  <?php endif;?>
</table>
