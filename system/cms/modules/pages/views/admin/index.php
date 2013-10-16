<div class="p">


	<!-- .row -->
	<div class="row">
	<div class="col-md-6">

			<!-- .panel -->
			<section class="panel panel-default">

				<div class="panel-heading">
					<h3 class="panel-title">
						<?php echo lang('pages:list_title') ?>
					</h3>
				</div>

				<!-- .panel-body -->
				<div class="panel-body">
					
					<div id="page-list" class="dd sortable" data-order-url="<?php echo site_url('admin/pages/order'); ?>">
						<ul class="dd-list">
							<?php echo tree_builder($pages, '<li data-id="{{ id }}" class="dd-item dd3-item"><div class="dd-handle dd3-handle">Drag</div><div class="dd3-content"><a href="#" class="{{ status }}" rel="{{ id }}">{{ title }}</a></div>{{ children }}</li>') ?>
						</ul>
					</div>

				</div>
				<!-- /.panel-body -->

			</section>
			<!-- /.panel -->

		</div>
		<div class="col-md-6">

			<!-- .panel -->
			<section class="panel panel-default">
			
				<div class="panel-heading">
					<h3 class="panel-title">
						<?php echo lang('pages:tree_explanation_title') ?>
					</h3>
				</div>

				<!-- .panel-body -->
				<div class="panel-body">

					<div id="page-details">
						<p>
							<?php echo lang('pages:tree_explanation') ?>
						</p>
					</div>

				</div>
				<!-- /.panel-body -->

			</section>
			<!-- /.panel -->

		</div>

	</div>
	</div>
	<!-- /.row -->


</div>