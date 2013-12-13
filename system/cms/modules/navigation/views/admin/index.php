<div class="p n-p-b">
	<?php file_partial('notices'); ?>
</div>

<div class="p">


	<?php if ( ! empty($groups)): ?>

		<?php foreach ($groups as $group): ?>

			
			<!-- .panel -->
			<section rel="<?php echo $group->id ?>" class="panel panel-default group-<?php echo $group->id ?>">

				<div class="panel-heading">

					<h3 class="panel-title">
						
						<span data-toggle="tooltip" data-original-title="<?php echo lang('nav:abbrev_label').': '.$group->abbrev ?>">
							<?php echo $group->title;?>
						</span>

						<div class="btn-group pull-right">
							<?php echo anchor('admin/navigation/groups/delete/'.$group->id, lang('global:delete'), array('class' => 'confirm btn btn-xs btn-danger',  'title' => lang('nav:group_delete_confirm'))) ?>
							<?php echo anchor('admin/navigation/create/'.$group->id, lang('nav:link_create_title'), 'rel="'.$group->id.'" class="btn btn-xs btn-success ajax add button ignore-loading"') ?>
						</div>
					</h3>

				</div>

				<?php if ( ! empty($navigation[$group->id])): ?>

					<div class="panel-body">
						
						<!-- .row -->
						<div class="row">

							<div class="col-lg-6">
								<div id="page-list" class="dd sortable" data-order-url="<?php echo site_url('admin/navigation/order/'.$group->id); ?>">
									<ul class="dd-list">
										<?php echo tree_builder($navigation[$group->id], '<li data-id="{{ id }}" class="dd-item dd3-item"><div class="dd-handle dd3-handle">Drag</div><div class="dd3-content"><a href="admin/navigation/edit/{{id}}" class="ajax" rel="'.$group->id.'">{{ title }}</a></div>{{ children }}</li>') ?>
									</ul>
								</div>
							</div>

							<div class="col-lg-6">
								<div id="link-details" class="group-<?php echo $group->id ?>">

									<p><?php echo lang('navs.tree_explanation') ?></p>

								</div>
							</div>
						</div>
						<!-- /.row -->

					</div>

				<?php else:?>

					<div class="panel-body">
						
						<!-- .row -->
						<div class="row">

							<div class="col-lg-6">
								<p><?php echo lang('nav:group_no_links');?></p>
							</div>

							<div class="col-lg-6">
								<div id="link-details" class="group-<?php echo $group->id ?>">

									<p><?php echo lang('navs.tree_explanation') ?></p>

								</div>
							</div>
						</div>
						<!-- /.row -->

					</div>

				<?php endif; ?>

			</section>
			<!-- /.panel -->


		<?php endforeach; ?>

	<?php else: ?>

		<div class="alert alert-info m">
			<p><?php echo lang('nav:no_groups');?></p>
		</div>

	<?php endif; ?>


</div>