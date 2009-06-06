<?=anchor('forums/topics/new_topic/'.$forumID, ' New Topic ');?> | <?=anchor('forums/posts/new_reply/'.$topicID, ' Reply ');?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <th colspan="3" align="left" bgcolor="#999999" scope="col"><?=$topic_name;?></th>
  </tr>
  
  <?php 
	$i=$offset;
	foreach($post_list as $post):	
  ?>
  <tr>
    <td width="20%" bgcolor="#CCCCCC"><?=getUserProfileNameLink($post['authorID']);?></td>
    <td width="50%" bgcolor="#CCCCCC">Posted: <?=$post['post_date'];?></td>
<? if($post['parentID'] == 0) { ?>
	<td width="30%" align=right bgcolor="#CCCCCC">[<?=anchor('forums/posts/report/'.$post['postID'], ' Report ');?>]</td>
<? } else { ?>
	<td width="35%" align=right bgcolor="#CCCCCC">[<?=anchor('forums/posts/report/'.$post['postID'], ' Report ');?>] [<?=anchor('forums/posts/view_reply/'.$post['postID'], ' # '.$i.' ' , array('title' => 'Permalink to this post', 'name' => $post['postID']));?>]</td>
<? } ?>
  </tr>
 
  <tr bgcolor="#DDDDDD">
    <td valign="top" class="authorinfo">
	<?=getUserDisplayPicFromId($post['authorID'], 'small');?><br/><br/>
	Total Posts: 
	<?='posts...';//$post['author']['user_postcount'];?><br/>
	Joined Date: 
	<?=$post['author']['created'];?>
	</td>
    <td colspan="2" valign="top"><?=$post['post_text'];?></td>
  </tr>
  
  <tr bgcolor="#B4B4B4">
    <td>[ <?=anchor('profiles/user/'.$post['authorID'], 'Profile')?> ] [ <?=anchor('messages/write/'. $post['authorID'], 'Message');?> ]</td>
	
	<td colspan="2" align="right">[ <?=anchor('forums/posts/quote_reply/'.$post['postID'], ' Quote ');?> ]
<? if($post['authorID'] == $userID && $post['parentID'] == 0): ?>
	 [ <?=anchor('forums/posts/edit_reply/'.$post['postID'], ' Edit ');?> ]
<?	endif; ?>
<? if($post['authorID'] == $userID && $post['parentID'] != 0): ?>
	 [ <?=anchor('forums/posts/edit_reply/'.$post['postID'], ' Edit ');?> ] [ <?=anchor('forums/posts/delete_reply/'.$post['postID'], ' Delete ');?> ]</td>
<? endif; ?>

  </tr>
  <?php
	$i++;
	endforeach; ?>
</table>

<?=$this->pagination->create_links(); ?>