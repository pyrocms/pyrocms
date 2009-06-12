<style type="text/css">
<!--
.lastpost_info {font-size: small}
.description {font-size: small}
-->
</style>

<?php foreach($category_list as $category): ?>

<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <th colspan="5" bgcolor="#999999" scope="col"><?=$category['category_name'];?></th>
  </tr>
  <tr>
    <td width="5%" bgcolor="#CCCCCC">&nbsp;</td>
    <td width="45%" bgcolor="#CCCCCC">Forum Name</td>
    <td width="10%" bgcolor="#CCCCCC">Topics</td>
    <td width="10%" bgcolor="#CCCCCC">Replies</td>
    <td width="30%" bgcolor="#CCCCCC">Last Post Info </td>
  </tr>

  <?php foreach($category['forum_list'] as $forum): ?>
  <tr bgcolor="#DDDDDD">
    <td></td>
    <td valign="top">
		<b><?=anchor('forums/view_forum/'.$forum['forumID'], $forum['forum_name']);?></b><br/>
		<span class="description"><?=$forum['forum_description'];?></span>
	</td>
    <td align="center" valign="middle" bgcolor="#DDDDDD"><?=$forum['topic_count'];?></td>
    <td align="center" valign="middle"><?=$forum['reply_count']?></td>
    <td class="lastpost_info">
	<?php if(isset($forum['last_post']['post_title'])):?>
	<?=anchor('forums/posts/view_reply/'.$forum['last_post']['postID'], $forum['last_post']['post_title']);?><br/>
	Posted: <?=$forum['last_post']['post_date'];?><br/>
	Author: <?=getUserProfileNameLink($forum['last_post']['authorID']);?>
	<?php endif;?>
	</td>
  </tr>
  <?php endforeach; ?>
  
</table>
<br/><br/>
<?php endforeach; ?>