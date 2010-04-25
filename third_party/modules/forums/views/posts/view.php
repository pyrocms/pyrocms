<?php echo $template['partials']['breadcrumbs']; ?>
<?php echo anchor('forums/topics/new_topic/'.$forum->id, ' New Topic ');?> | <?php echo anchor('forums/posts/new_reply/'.$topic->id, ' Reply ');?>

<table class="topic_table" border="0" cellspacing="0">
	<thead>
	<tr>
		<th colspan="4" class="header"><?php echo $topic->title;?></th>
	</tr>
	</thead>
	<tbody>
  <?php 
	$i=$pagination->offset;
	foreach($topic->posts as $post):
  ?>
	<tr class="postinfo">
    <td width="20%"><?php echo $post->author->full_name;?></td>
    <td width="50%">Posted: <?php echo date("m.d.y \a\\t g.i a", $post->created_on);?></td>
<?php if($post->parent_id == 0): ?>
	<td width="30%" class="postreport">[<?php echo anchor('forums/posts/report/'.$post->id, ' Report ');?>]</td>
<?php else: ?>
	<td width="35%" class="postreport">[<?php echo anchor('forums/posts/report/'.$post->id, ' Report ');?>] [<?php echo anchor('forums/posts/view_reply/'.$post->id, ' # '.$i.' ' , array('title' => 'Permalink to this post', 'name' => $post->id));?>]</td>
<?php endif; ?>
  </tr>
 
  <tr>
    <td valign="top" class="authorinfo">
	<?php echo gravatar($post->author->email);?><br/><br/>
	Joined Date: 
	<?php echo date("m.d.y", $post->author->created_on);?>
	</td>
    <td colspan="2" valign="top"><?php echo parse_bbcode($post->content); ?></td>
  </tr>
  
  <tr class="postlinks">
    <td>[ <?php echo anchor('user/'.$post->author->id, 'Profile')?> ] [ <?php echo anchor('messages/write/'. $post->author->id, 'Message');?> ]</td>
	
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
	</tbody>
</table>

<?php echo $pagination->links; ?>