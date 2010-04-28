<div class="forum_buttons">
	<?php echo anchor('forums/topics/new_topic/'.$forum->id, ' New Topic ');?>
	<?php echo anchor('forums/posts/new_reply/'.$topic->id, ' Reply ');?>
	<br clear="both" />
</div>
<div class="pagination">
<?php echo $pagination->links; ?>
</div>
<h2><?php echo $this->config->item('forums_title'); ?></h2>
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
		<td width="20%">
		<?php
		if($this->settings->item('enable_profiles')):
			echo anchor('user/'.$post->author->id, $post->author->full_name);
		else:
			echo $post->author->full_name;
		endif;
		?>
		</td>
    <td width="50%">Posted: <?php echo date("m.d.y \a\\t g.i a", $post->created_on);?></td>
<?php if($post->parent_id == 0): ?>
	<td width="30%" class="postreport">
		[ <?php echo anchor('forums/posts/report/'.$post->id, 'Report');?> ]
		<?php if($this->ion_auth->is_admin() && !$topic->sticky): ?>
		[ <?php echo anchor('forums/topics/stick/'.$post->id, 'Make Sticky');?> ]
		<?php else: ?>
		[ <?php echo anchor('forums/topics/unstick/'.$post->id, 'Unstick');?> ]
		<?php endif; ?>
	</td>
<?php else: ?>
	<td width="35%" class="postreport">[ <?php echo anchor('forums/posts/report/'.$post->id, 'Report');?> ] [ <?php echo anchor('forums/posts/view_reply/'.$post->id, '# '.$i , array('title' => 'Permalink to this post', 'name' => $post->id));?> ]</td>
<?php endif; ?>
  </tr>
 
  <tr>
    <td valign="top" class="authorinfo">
		<a href="<?php echo site_url('user/'.$post->author->id); ?>">
			<?php echo gravatar($post->author->email);?>
		</a>

		<p>
			Joined Date:
			<?php echo date("m.d.y", $post->author->created_on);?>
		</p>
		<p>
			Posts:
			<?php echo $post->author->post_count;?>
		</p>
	</td>
    <td colspan="2" valign="top"><?php echo parse_bbcode($post->content, 0, TRUE); ?></td>
  </tr>
  
  <tr class="postlinks">
    <td>
		<!--<?php if(isset($user->id)): ?>
		[ <?php echo anchor('messages/create/'.$post->author->id, 'Message');?> ]
		<?php endif; ?>-->
	</td>
	
	<td colspan="2" align="right">[ <?php echo anchor('forums/posts/quote_reply/'.$post->id, 'Quote');?> ]
<?php if(isset($user->id) && $post->author->id == $user->id && $post->parent_id == 0): ?>
	 [ <?php echo anchor('forums/posts/edit_reply/'.$post->id, 'Edit');?> ]
<?	elseif((isset($user->id) && $post->author->id == $user->id && $post->parent_id != 0) || $this->ion_auth->is_admin()): ?>
	 [ <?php echo anchor('forums/posts/edit_reply/'.$post->id, 'Edit');?> ] 
	 [ <?php echo anchor('forums/posts/delete_reply/'.$post->id, 'Delete');?> ]
	</td>
<?php endif; ?>

	  </tr>
  <?php
	$i++;
	endforeach; ?>
	</tbody>
</table>
<div class="pagination">
<?php echo $pagination->links; ?>
</div>

<div class="forum_buttons">
	<?php echo anchor('forums/topics/new_topic/'.$forum->id, ' New Topic ');?>
	<?php echo anchor('forums/posts/new_reply/'.$topic->id, ' Reply ');?>
	<br clear="both" />
</div>