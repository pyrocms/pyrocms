<noscript>
	<span>PyroCMS requires that JavaScript be turned on for many of the functions to work correctly. Please turn JavaScript on and reload the page.</span>
</noscript>

<div class="topbar" dir=<?php $vars = $this->load->get_vars(); echo $vars['lang']['direction'] ?>>
	<div class="topbar-inner">
		<div class="wrapper">
			<div id="logo">
				<!-- <?php echo anchor('', Asset::img('logo.png', 'view site'), 'target="_blank"') ?> -->
				<?php echo anchor('','<span id="pyro-logo"></span>', 'target="_blank"') ?>
			</div>
		
			<nav id="primary">
				<?php file_partial('navigation') ?>
			</nav>
			
			<div class="topbar-form">
	
				<script type="text/javascript">
					jQuery(function($) {
						$(function() {
							var cache = {}, lastXhr;
							$(".search-query").autocomplete({
								minLength: 2,
								delay: 300,
								source: function( request, response ) {
									var term = request.term;
									if ( term in cache ) {
										response( cache[ term ] );
										return;
									}
	
									lastXhr = $.getJSON(SITE_URL + 'admin/search/ajax_autocomplete', request, function( data, status, xhr ) {
										cache[ term ] = data.results;
										if ( xhr === lastXhr ) {
											response( data.results );
										}
									});
								},
								focus: function(event, ui) {
									// $("#searchform").val( ui.item.label);
									return false;
								},
								select: function(event, ui) {
									window.location.href = ui.item.url;
									return false;
								}
							})
							.data("autocomplete")._renderItem = function(ul, item){
								return $("<li></li>")
								.data("item.autocomplete", item)
								.append('<a href="' + item.url + '">' + item.title + '</a><div class="keywords">' + item.keywords + '</div><div class="singular">' + item.singular + '</div>')
								.appendTo(ul);
							};
						});
					});
				</script>
	
	
				<form class="topbar-search">
					<input type="text" class="search-query" id="nav-search" placeholder="Search" ontouchstart="">
				</form>
			</div>
			
		</div>
	</div>
	
</div>

<div class="subbar">
	<div class="wrapper">
		<div class="subbar-inner">
			<h2><?php echo $module_details['name'] ? anchor('admin/'.$module_details['slug'], $module_details['name']) : lang('global:dashboard') ?></h2>
		
			<small>
				<?php if ( $this->uri->segment(2) ) { echo '&nbsp; | &nbsp;'; } ?>
				<?php echo $module_details['description'] ? $module_details['description'] : '' ?>
			</small>
	
			<?php file_partial('shortcuts') ?>
	
		</div>
	</div>
</div>

<?php if ( ! empty($module_details['sections'])) file_partial('sections') ?>
