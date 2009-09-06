<?
/*foreach($this->modules_m->getModules(array('is_backend'=>true, 'type'=>'admin')) as $module): ?>
	<div class="width-quater float-left align-center" style="height:8em">
		<?= anchor('admin/'.$module['slug'], $module['name']); ?>
	</div>
<? endforeach;*/
?>
<!-- To do: Replace the shitty inline styles and update the message -->
<strong><?= sprintf(lang('cp_welcome'), $this->settings->item('site_name'));?> <span style="color:red;">(!)</span></strong>
<!-- Fancy site stats -->
<h3>Site Stats</h3>
<ul class='stats_list'>
	<li>
		<?php if($this->data->total_pages == 1)
		{
			echo '1 Page';
		}
		else
		{
			echo $this->data->total_pages . ' Pages';
		}
		?>
	</li>
	<li>
		<?php if($this->data->live_articles == 1)
		{
			echo '1 Article';
		}			
		else
		{
			echo $this->data->live_articles . ' Articles';
		}
		?>
	</li>
	<li>
		<?php if($this->data->approved_comments == 1)
		{
			echo '1 Comment';
		}			
		else
		{
			echo $this->data->approved_comments . ' Comments';
		}
		?>
	</li>
	<li>		
		<?php if($this->data->total_users == 1)
		{
			echo '1 User';
		}
		else
		{
			echo $this->data->total_users . ' Users';
		}
		?>
	</li>
</ul>
<!-- Delicious, home baked RSS feeds. -->
<h3>RSS Feeds</h3>
<ul id='feed_list'>
	<?php foreach($this->data->rss_items as $rss_item): ?>
	<li class='rss_item'>
		<strong class='item_name'><a href="<?php echo $rss_item->get_permalink(); ?>"><?php echo $rss_item->get_title(); ?></a></strong>
		<p class='item_date'><?php echo $rss_item->get_date(); ?></p>
		<p class='item_body'><?php echo $rss_item->get_description(); ?></p>
	</li>
	<?php endforeach; ?>
</ul>