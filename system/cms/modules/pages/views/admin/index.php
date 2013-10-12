<div class="padding">


	<!-- .row -->
	<div class="row">
	<div class="col-md-6">

			<!-- .panel -->
			<section class="panel panel-default">
			
				<!-- .panel-content -->
				<div class="panel-content">

					<div class="panel-heading">
						<h3 class="panel-title">
							<?php echo lang('pages:list_title') ?>
						</h3>
					</div>
					
					<div id="page-list" class="dd padding">
						<ul class="dd-list sortable">
							<?php echo tree_builder($pages, '<li id="page_{{ id }}" class="dd-item dd3-item"><div class="dd-handle dd3-handle">Drag</div><div class="dd3-content"><a href="#" class="{{ status }}" rel="{{ id }}">{{ title }}</a></div>{{ children }}</li>') ?>
						</ul>
					</div>

				</div>
				<!-- /.panel-content -->

			</section>
			<!-- /.panel -->

		</div>
		<div class="col-md-6">

			<!-- .panel -->
			<section class="panel panel-default">
			
				<!-- .panel-content -->
				<div class="panel-content">

					<div class="panel-heading">
						<h3 class="panel-title">
							<?php echo lang('pages:tree_explanation_title') ?>
						</h3>
					</div>

					<div id="page-details" class="padding">
						<p>
							<?php echo lang('pages:tree_explanation') ?>
						</p>
					</div>

				</div>
				<!-- /.panel-content -->

			</section>
			<!-- /.panel -->

		</div>

	</div>
	</div>
	<!-- /.row -->


</div>