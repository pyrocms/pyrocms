<div class="padding">


	<!-- .panel -->
	<section class="panel panel-default">
	
		<!-- .panel-content -->
		<div class="panel-content">

			<div class="panel-heading">
				<h3 class="panel-title">
					<?php if(isset($template['page_title'])) { echo lang_label($template['page_title']); } ?>
				</h3>
			</div>

			<?php echo $content; ?>

		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>