<div class="ajax-tabs">
	<?php echo $template['partials']['nav']; ?>
	<?php
		if(isset($template['partials']['non-js'])):
			echo $template['partials']['non-js'];
		endif;
	?>
</div>

<style type="text/css">
.ajax-tabs ul {
	margin-bottom: 10px;
	background-color: none;
}
</style>