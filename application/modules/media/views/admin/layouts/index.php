<style type="text/css">

#media_browser {
	display: table;
	width: 100%;
	margin-bottom: 20px;
	background-color: #FFFFFF;
	color: #333333;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	-o-border-radius: 5px;
	border-radius: 5px;
	border: 1px solid #CCCCCC;
}
#media_left_pane {
	width: 15%;
	display: table-cell;
	border-right: 1px solid #CCCCCC;
	padding: 10px 0;
	
}
#media_browser h3 {
	margin: 0px;
	padding: 3px 0 5px 0px;	
}
#media_left_pane h3 {
	padding-left: 10px;
}
#media_right_pane {
	width: 85%;
	display: table-cell;
	padding: 10px;
}
#media_left_pane li a {
	padding: 10px;
	background: transparent;
	display: block;
	text-decoration: none;
	color: #666666;
}
#media_left_pane li a:hover {
	background-color: #F4F4F4;
	color: #333333;
}
#media_left_pane li.current a {
	background-color: #3a4043;
	color: #FFFFFF;
}
</style>
<div id="media_browser">
	<div id="media_left_pane">
		<h3><?php echo lang('media.folders.title'); ?></h3>
		<?php echo $template['partials']['nav']; ?>
	</div>
	<div id="media_right_pane">
	</div>
</div>
<script type="text/javascript">
(function($) {
	$(function() {
		$("#media_left_pane li a").click(function() {
			curr_url = $(this).attr("href");
			curr_text = $(this).text();
			$(this).text("Loading...");
			$("#media_right_pane").load(curr_url);
			$(this).parent().parent().find('li').removeClass('current');
			$(this).parent().addClass('current');
			$(this).text(curr_text);
			return false;
		});

		$("#media_left_pane li:first-child a").click();
	});
})(jQuery);
</script>