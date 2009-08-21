<div id="footer-wrap">
	<div id="footer-content">	
		<div class="col float-left space-sep">
			<h3>Resources</h3>
			<ul class="col-list">				
				<li><a href="http://www.cssmania.com/">CSSMania - <span>CSS Design Showcase</span></a></li>
				<li><a href="http://www.alistapart.com/">AListApart - <span>For People Who Make Websites</span></a></li>
				<li><a href="http://www.pdphoto.org/">PDPhoto.org - <span>Public Domain Photos</span></a></li>						
				<li><a href="http://www.freephotos.se/">FreePhotos.se - <span>Free &amp; Public Domain Photos</span></a></li>	
				<li><a href="http://www.fotolia.com/partner/114283">Fotolia - <span>Free stock images or from $1</span></a></li>						
			</ul>
		</div>

		<div class="col float-left">
			<h3>Lorem Ipsum</h3>
			<p>
			<strong>Lorem ipsum dolor</strong> <br />
			Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu 
			posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum 
			odio, ac blandit ante orci ut diam. <a href="index.html">Read more...</a>
			</p>
			
			<ul class="col-list">				
				<li><a href="index.html">consequat molestie</a></li>
				<li><a href="index.html">sem justo</a></li>
				<li><a href="index.html">semper</a></li>
			</ul>
		</div>		

		<div class="col2 float-right">
			<h3>About</h3>
						
			<p>
			<a href="http://getfirefox.com/"><img src="<?php echo base_url(); ?>application/themes/freshmedia/images/thumb.jpg" width="40" height="40" alt="firefox" class="float-left" /></a>
			Donec libero. Suspendisse bibendum. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu 
			posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum 
			odio, ac blandit ante orci ut diam.</p>
						
			<p>&copy; copyright <?php echo date('Y'); ?> <strong><?php echo $this->settings->item('site_name'); ?></strong><br /> 
			Powered by: <a href="http://www.pyrocms.com/" title="PyroCMS">PyroCMS</a> &nbsp; &nbsp;Design by: <a href="index.html">styleshout</a><br />
			Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://validator.w3.org/check/referer">XHTML</a>
			</p>
			
			<p>
			<?php if(!empty($navigation['footer'])): 
				$last_link = array_pop($navigation['footer']);
			
				foreach($navigation['footer'] as $nav_link): ?>
					<?php echo anchor($nav_link->url, $nav_link->title); ?> | 
				<?php endforeach;
			
				echo anchor($last_link->url, $last_link->title);
			endif; ?>
			</p>

		</div>
	</div>
</div>
<div class="clearer"></div>
<?php // Google Tracker ?>
<?php if($this->settings->item('google_analytic')): ?>
	<?php $this->load->view('fragments/google_analytic'); ?>
<?php endif; ?>