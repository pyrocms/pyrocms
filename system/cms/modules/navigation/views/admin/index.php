<?php if ( ! empty($groups)): ?>
	<?php foreach ($groups as $group): ?>

		<section rel="<?php echo $group->id ?>" class="group-<?php echo $group->id ?> box">
			<div class="one_full">
				<section class="title files-title">
					<ul>
						<li>
							<h4 class="tooltip" title="<?php echo lang('nav:abbrev_label').': '.$group->abbrev ?>"><?php echo $group->title;?></h4>
						</li>

						<li><?php echo anchor('admin/navigation/groups/delete/'.$group->id, lang('global:delete'), array('class' => 'tooltip-e confirm btn button red',  'title' => lang('nav:group_delete_confirm'))) ?></li>
						<li>
							<!-- <h4 class="form-title group-title-<?php echo $group->id ?>"></h4> -->
							<?php echo anchor('admin/navigation/create/'.$group->id, lang('nav:link_create_title'), 'rel="'.$group->id.'" class="add ajax button"') ?>
						</li>
					</ul>

				</section>

				<?php if ( ! empty($navigation[$group->id])): ?>

				<section class="item collapsed">
						<div class="content">
							<div class="one_half">
								<div id="link-list">
									<ul class="sortable">
										<?php echo tree_builder($navigation[$group->id], '<li id="link_{{ id }}"><div><a href="#" rel="'.$group->id.'" alt="{{ id }}">{{ title }}</a></div>{{ children }}</li>') ?>
									</ul>
								</div>
							</div>

							<div class="one_half last">
								<div id="link-details" class="group-<?php echo $group->id ?>">

									<p>
										<?php echo lang('navs.tree_explanation') ?>
									</p>

								</div>
							</div>
						</div>
					</section>
				</div>

				<?php else:?>

				<section class="item collapsed">
					<div class="content">
						<div class="one_half">
							<div id="link-list" class="empty">
								<ul class="sortable">

									<p><?php echo lang('nav:group_no_links');?></p>

								</ul>
							</div>
						</div>

						<div class="one_half last">
							<div id="link-details" class="group-<?php echo $group->id ?>">

								<p>
									<?php echo lang('navs.tree_explanation') ?>
								</p>

							</div>
						</div>
					</div>
				</section>
				<?php endif ?>

		</section>

	<?php endforeach ?>

<?php else: ?>
	<div class="blank-slate">
		<p><?php echo lang('nav:no_groups');?></p>
	</div>
<?php endif ?>