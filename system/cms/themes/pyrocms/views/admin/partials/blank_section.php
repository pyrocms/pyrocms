<div class="padded">
	<section class="box">

		<?php if (isset($template['partials']['box_header'])): ?>
			
			<?php echo $template['partials']['box_header']; ?>

		<?php else: ?>
			
			<section class="box-header">
				<?php if(isset($template['page_title'])) { echo '<span class="title">'.lang_label($template['page_title']).'</span>'; } ?>
			</section>

		<?php endif; ?>

		<?php echo $content; ?>
	</section>
</div>