<noscript>
	<span>PyroCMS requires that JavaScript be turned on for many of the functions to work correctly. Please turn JavaScript on and reload the page.</span>
</noscript>

<div class="topbar" dir=<?php $vars = $this->load->_ci_cached_vars; echo $vars['lang']['direction']; ?>>
	
	<div id="logo">
		<?php echo anchor('', $this->settings->site_name, 'target="_blank"'); ?>
	</div>
	
	<nav>
		<?php file_partial('navigation'); ?>
	</nav>
	
	<ul id="lang" class="primary-nav">
		<form action="<?php echo current_url(); ?>" id="change_language" method="get">
			<select class="chzn" name="lang" onchange="this.form.submit();">				
				<?php foreach($this->config->item('supported_languages') as $key => $lang): ?>
		    		<option value="<?php echo $key; ?>" <?php echo CURRENT_LANGUAGE == $key ? 'selected="selected"' : ''; ?>>
						<?php echo $lang['name']; ?>
					</option>
        		<?php endforeach; ?>
	    	</select>
		</form>
	</ul>
	
</div>