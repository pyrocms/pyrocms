<?php echo anchor('forums/topics/new_topic/'.$forum->id, ' New Topic ');?> | <?php echo anchor('forums/posts/new_reply/'.$topic->id, ' Reply ');?>

<h2><?php echo $topic->title;?></h2>

<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <?php 
	$i=$pagination->offset;
	foreach($topic->posts as $post):	
  ?>
  <tr>
    <td width="20%"><?php echo $post->author->full_name;?></td>
    <td width="50%">Posted: <?php echo $post->created_on;?></td>
<?php if($post->parent_id == 0): ?>
	<td width="30%">[<?php echo anchor('forums/posts/report/'.$post->id, ' Report ');?>]</td>
<?php else: ?>
	<td width="35%">[<?php echo anchor('forums/posts/report/'.$post->id, ' Report ');?>] [<?php echo anchor('forums/posts/view_reply/'.$post->id, ' # '.$i.' ' , array('title' => 'Permalink to this post', 'name' => $post->id));?>]</td>
<?php endif; ?>
  </tr>
 
  <tr>
    <td valign="top" class="authorinfo">
	<?php echo gravatar($post->author->email);?><br/><br/>
	Joined Date: 
	<?php echo $post->author->created_on;?>
	</td>
    <td colspan="2" valign="top"><?php echo $post->content; //parse_bbcode($post->text);?></td>
  </tr>
  
  <tr>
    <td>[ <?php echo anchor('profiles/user/'.$post->author->id, 'Profile')?> ] [ <?php echo anchor('messages/write/'. $post->author->id, 'Message');?> ]</td>
	
	<td colspan="2" align="right">[ <?php echo anchor('forums/posts/quote_reply/'.$post->id, ' Quote ');?> ]
<?php if($post->author->id == $user->id && $post->parent_id == 0): ?>
	 [ <?php echo anchor('forums/posts/edit_reply/'.$post->id, ' Edit ');?> ]
<?	endif; ?>
<?php if($post->author->id == $user->id && $post->parent_id != 0): ?>
	 [ <?php echo anchor('forums/posts/edit_reply/'.$post->id, ' Edit ');?> ] [ <?php echo anchor('forums/posts/delete_reply/'.$post->id, ' Delete ');?> ]</td>
<?php endif; ?>

  </tr>
  <?php
	$i++;
	endforeach; ?>
</table>

<?php echo $pagination->links; ?>