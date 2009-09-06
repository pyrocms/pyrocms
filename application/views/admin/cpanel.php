<?
/*foreach($this->modules_m->getModules(array('is_backend'=>true, 'type'=>'admin')) as $module): ?>
	<div class="width-quater float-left align-center" style="height:8em">
		<?= anchor('admin/'.$module['slug'], $module['name']); ?>
	</div>
<? endforeach;*/
?>
<!-- To do: Replace the shitty inline styles and update the message -->
<strong><?= sprintf(lang('cp_welcome'), $this->settings->item('site_name'));?> <span style="color:red;">(!)</span></strong>
<ul id='stats_list'>
	<!-- Global stats -->
	<li id='stats_global'>
		<h3>General</h3>
		<?php if($this->data->total_pages == 1): ?>
		<p>1 Page</p>
		<?php else: ?>
		<p><?php echo $this->data->total_pages; ?> Pages</p>
		<?php endif; ?>
		
		<?php if($this->data->live_articles == 1): ?>
		<p>1 Article</p>	
		<?php else: ?>
		<p><?php echo $this->data->live_articles; ?> Articles</p>
		<?php endif; ?>
		
		<?php if($this->data->total_users == 1): ?>
		<p>1 User</p>	
		<?php else: ?>
		<p><?php echo $this->data->total_users; ?> Users</p>
		<?php endif; ?>
	</li>
	<!-- Comment stats -->
	<li id='stats_comments'>
		<h3>Comments</h3>
		<?php if($this->data->total_comments == 1): ?>
		<p>1 Comment</p>
		<?php else: ?>
		<p><?php echo $this->data->total_comments; ?> Comments</p>
		<?php endif; ?>
		<p><?php echo $this->data->approved_comments; ?> Approved</p>
		<p><?php echo $this->data->pending_comments; ?> Pending</p>
	</li>
</ul>
