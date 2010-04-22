<style type="text/css">
<!--
.lastpost_info {font-size: small}
.description {font-size: small}
-->
</style>

<?php foreach($forum_categories as $category): ?>
<?php if($category->forums): ?>

<table width="100%" border="0" cellpadding="4" cellspacing="0">
	<thead>
	  <tr>
	    <th colspan="5" bgcolor="#999999" scope="col"><?php echo $category->title;?></th>
	  </tr>
	  <tr>
	    <th>&nbsp;</th>
	    <th>Forum Name</th>
	    <th>Topics</th>
	    <th>Replies</th>
	    <th>Last Post Info </th>
	  </tr>
	</thead>
	
	<tbody>

  <?php foreach($category->forums as $forum): ?>
  <tr>
    <td></td>
    <td valign="top">
		<b><?php echo anchor('forums/view/'.$forum->id, $forum->title);?></b><br/>
		<span class="description"><?php echo $forum->description;?></span>
	</td>
    <td align="center" valign="middle"><?php echo $forum->topic_count; ?></td>
    <td align="center" valign="middle"><?php echo $forum->reply_count; ?></td>
    <td class="lastpost_info">
		<?php if(isset($forum->last_post->title)):?>
		<?php echo anchor('forums/posts/view_reply/'.$forum->last_post->id, $forum->last_post->title); ?><br/>
		Posted: <?php echo date('d M y', $forum->last_post->created_on); ?><br/>
		Author: <?php echo $this->users_m->get(array('id' => $forum->last_post->author_id))->full_name; ?>
		<?php endif;?>
	</td>
  </tr>
  <?php endforeach; ?>
  
  </tbody>
  
</table>
<br/><br/>
<?php endif; ?>
<?php endforeach; ?>