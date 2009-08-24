    <div class="width-half float-left">
      &copy;2008 <?=$this->settings->item('site_name'); ?> <span class="grey">|</span>
      valid <a href="http://validator.w3.org/check?uri=referer" title="Validate XHTML">XHTML</a> <span class="grey">|</span>
      should be valid <a href="http://jigsaw.w3.org/css-validator" title="Validate CSS">CSS</a>
    </div>

    <div class="width-half float-right">
		<? if(!empty($navigation['footer'])): 
			$last_link = array_pop($navigation['footer']);
			
			foreach($navigation['footer'] as $nav_link): ?>
				<?=anchor($nav_link->url, $nav_link->title); ?> | 
			<? endforeach;
			
			echo anchor($last_link->url, $last_link->title);
		endif; ?>
    </div>
    
<? // Google Tracker ?>
<? if($this->settings->item('google_analytic')): ?>
	<? $this->load->view('fragments/google_analytic'); ?>
<? endif; ?>