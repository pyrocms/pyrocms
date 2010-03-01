<?php 
if(empty($bookmark['url'])) $bookmark['url'] = site_url($this->uri->uri_string());
if(empty($bookmark['title'])) $bookmark['title'] = $page_title;

if(empty($type)) $type = 'general';
?>

<div class="social-bookmarks">
	
	<h3><?php echo lang('tb_title');?></h3>
	
	<ul class="list-inline">
		<?php echo $this->load->view('fragments/social_bookmarking/'.$type.'_bookmarks', array('type' => $type, 'bookmark' => $bookmark)); ?>
	</ul>
	
	<br class="clear-both" />
</div>