<?=anchor('forums/topics/new_topic/'.$forumID, ' New Topic ');?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <th colspan="5" bgcolor="#999999" scope="col"><?=$forum_name;?></th>
  </tr>
  <tr>
    <td width="5%" bgcolor="#CCCCCC">&nbsp;</td>
    <td width="45%" bgcolor="#CCCCCC">Topic Name</td>
    <td width="10%" bgcolor="#CCCCCC">Posts</td>
    <td width="10%" bgcolor="#CCCCCC">Views</td>
    <td width="30%" bgcolor="#CCCCCC">Last Post Info </td>
  </tr>
  
  <? if(empty($topic_list)):?>
 <tr bgcolor="#DDDDDD">
    <td colspan="5" align="center">There are no posts in this topic right now.</td>
  </tr>
  
  <? else: ?>
  
  <? foreach($topic_list as $topic): ?>
  <tr bgcolor="#DDDDDD">
    <td></td>
    <td valign="top">
		<b><?=anchor('forums/topics/view_topic/'.$topic['postID'], $topic['post_title']);?></b><br/>
		Author: <?=getUserProfileNameLink($topic['authorID']);?>
	</td>
    <td align="center" valign="middle" bgcolor="#DDDDDD"><?=$topic['post_count'];?></td>
    <td align="center" valign="middle"><?=$topic['post_viewcount']?></td>
    <td>
	<? if(!empty($topic['last_post'])):?>
	<?=anchor('forums/posts/view_reply/'.$topic['last_post']['postID'], $topic['last_post']['post_date']);?><br/>
	Author: <?=getUserProfileNameLink($topic['last_post']['authorID']);?>
	<? endif;?>
	</td>
  </tr>
  <? endforeach; ?>
  
  <? endif;?>
</table>
