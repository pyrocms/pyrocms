<section class="padded">
<div class="container-fluid">


	<?php if ( ! empty($groups)): ?>
		<?php foreach ($groups as $group): ?>

			<section rel="<?php echo $group->id ?>" class="group-<?php echo $group->id ?>">
				
				<div class="row-fluid">

					<section class="box">

						<section class="box-header">
							
							<span class="title" title="<?php echo lang('nav:abbrev_label').': '.$group->abbrev ?>"><?php echo $group->title;?></span>

							<ul class="box-toolbar">
								<li class="ibutton-container">
									<div class="btn-group pull-right margin-right">
										<?php echo anchor('admin/navigation/create/'.$group->id, lang('nav:link_create_title'), 'rel="'.$group->id.'" class="btn btn-small btn-success ajax"') ?>
										<?php echo anchor('admin/navigation/groups/delete/'.$group->id, lang('global:delete'), array('class' => 'confirm btn btn-small btn-danger',  'title' => lang('nav:group_delete_confirm'))) ?>
									</div>
								</li>
							</ul>

						</section>

						<div class="box-content padded">

							<?php if ( ! empty($navigation[$group->id])): ?>

								<div class="container-fluid">
								<div class="row-fluid">

									<div class="span6">
										<div id="link-list">
											<ul class="sortable">
												<?php echo tree_builder($navigation[$group->id], '<li id="link_{{ id }}"><div><a href="#" rel="'.$group->id.'" alt="{{ id }}">{{ title }}</a></div>{{ children }}</li>') ?>
											</ul>
										</div>
									</div>

									<div class="span6">
										<div id="link-details" class="group-<?php echo $group->id ?>">

											<p>
												<?php echo lang('navs.tree_explanation') ?>
											</p>

										</div>
									</div>

								</div>
								</div>

							<?php else:?>

								<div class="container-fluid">
								<div class="row-fluid">

									<div class="span6">
										<div id="link-list">
											<p><?php echo lang('nav:group_no_links');?></p>
										</div>
									</div>

									<div class="span6">
										<div id="link-details" class="group-<?php echo $group->id ?>">

											<p>
												<?php echo lang('navs.tree_explanation') ?>
											</p>

										</div>
									</div>

								</div>
								</div>

							<?php endif; ?>

						</div>

					</section>
				
				</div>


			</section>

		<?php endforeach ?>

	<?php else: ?>
		<div class="blank-slate">
			<p><?php echo lang('nav:no_groups');?></p>
		</div>
	<?php endif ?>


</div>
</section>