    <div class="width-half float-left">
      &copy;2008 <?php echo $this->settings->item('site_name'); ?> <span class="grey">|</span>
      valid <a href="http://validator.w3.org/check?uri=referer" title="Validate XHTML">XHTML</a> <span class="grey">|</span>
      should be valid <a href="http://jigsaw.w3.org/css-validator" title="Validate CSS">CSS</a>
    </div>

    <div class="width-half float-right">
		<?php if(!empty($navigation['footer'])): 
			$last_link = array_pop($navigation['footer']);
			
			foreach($navigation['footer'] as $nav_link): ?>
				<?php echo anchor($nav_link->url, $nav_link->title); ?> | 
			<?php endforeach;
			
			echo anchor($last_link->url, $last_link->title);
		endif; ?>
    </div>
    
<?php // Google Tracker ?>
<?php if($this->settings->item('google_analytic')): ?>
	<?php $this->load->view('fragments/google_analytic'); ?>
<?php endif; ?>