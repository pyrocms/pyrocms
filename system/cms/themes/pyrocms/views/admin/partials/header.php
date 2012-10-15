<noscript>
	<span>PyroCMS requires that JavaScript be turned on for many of the functions to work correctly. Please turn JavaScript on and reload the page.</span>
</noscript>

<div class="primary_bar">
	<div class="wrapper">
		<div id="welcome">
			<?php echo gravatar($current_user->email, 25); ?> <?php echo anchor('edit-profile', sprintf(lang('cp_logged_in_welcome'), $current_user->display_name . ' <i class="icon-edit icon-white"></i>')); ?>
		</div>

		<nav id="usernav">
			<ul>
				<li><i class="icon-eye-open icon-white"></i> <?php echo anchor('', lang('cp_view_frontend'), 'target="_blank"'); ?></li>
				<li><i class="icon-off icon-white"></i> <?php echo anchor('admin/logout', lang('cp_logout_label')); ?></li>
				<li><i class="icon-question-sign icon-white"></i> <?php echo anchor('admin/help/'.$module_details['slug'], lang('help_label'), array('title' => lang('help_label').'->'.$module_details['name'], 'class' => 'modal')); ?></li>
			</ul>
		</nav>
	</div>
</div>

<div class="secondary_bar" dir="<?php $lang = $this->load->get_var('lang'); echo $lang['direction']; ?>">
	<div class="wrapper">
		<nav id="primary">
			<?php file_partial('navigation'); ?>
		</nav>
		<div id="search">
			<script type="text/javascript">
				jQuery(function($) {

					$(function() {
						var cache = {}, lastXhr;

						$("#searchform").autocomplete({
							minLength: 0,
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
			<input id="searchform" name="searchform" type="text" placeholder="Type something and hit enter..." />
		</div>
	</div>
</div>

<div class="subbar">
	<div class="wrapper">
		<h2><?php echo $module_details['name'] ? anchor('admin/'.$module_details['slug'], $module_details['name']) : lang('global:dashboard'); ?></h2>
	
		<small>
			<?php if ( $this->uri->segment(2) ) { echo '&nbsp; &mdash;&nbsp;'; } ?>
			<?php echo $module_details['description'] ? $module_details['description'] : ''; ?>
		</small>

		<?php file_partial('shortcuts'); ?>

	</div>
</div>

<?php if ( ! empty($module_details['sections'])) file_partial('sections'); ?>