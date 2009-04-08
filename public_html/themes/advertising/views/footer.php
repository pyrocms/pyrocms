	<p>
		<? if(!empty($navigation['footer'])): 
			$last_link = array_pop($navigation['footer']);
			
			foreach($navigation['footer'] as $nav_link): ?>
				<?=anchor($nav_link->url, $nav_link->title); ?> | 
			<? endforeach;
			
			anchor($last_link->url, $last_link->title);
		endif; ?>
		
	<br />
	
	&copy;2008 <?=$this->settings->item('site_name'); ?>. All Rights Reserved. &nbsp;&bull;&nbsp; Designed by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
