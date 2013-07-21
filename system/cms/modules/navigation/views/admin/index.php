<section class="padded">
<div class="container-fluid">


	<?php if ( ! empty($groups)): ?>
	<?php foreach ($groups as $group): ?>


		<!-- Box -->
		<section class="box">

			<!-- Header -->
			<section class="box-header">
				<span class="title" title="<?php echo lang('nav:abbrev_label').': '.$group->abbrev ?>"><?php echo $group->title;?></span>

				<!-- Toolbar -->
				<div class="box-toolbar">

					<div class="btn-group pull-right margin-right">
						<?php echo anchor('admin/navigation/create/'.$group->id, lang('nav:link_create_title'), 'rel="'.$group->id.'" class="add ajax btn btn-small btn-success"') ?>
						<?php echo anchor('admin/navigation/groups/delete/'.$group->id, lang('global:delete'), array('class' => 'tooltip-e confirm btn btn-small btn-danger',  'title' => lang('nav:group_delete_confirm'))) ?>
					</div>
				</div>
			</section>


			<!-- Box Content -->
			<section class="box-content">

				<?php if ( ! empty($navigation[$group->id])): ?>


					<div class="row-fluid">
				
						<div class="span6">

							<div class="dd links-list-wrapper padded">
							
								<ul class="dd-list">

									<?php echo tree_builder($navigation[$group->id], '<li class="dd-item" id="link_{{ id }}"><div class="dd-handle dd3-handle"></div><div class="dd3-content"><a href="#" rel="'.$group->id.'" alt="{{ id }}">{{ title }}</a></div>{{ children }}</li>') ?>

								</ul>

							</div>

						</div>

						<div class="span6">

							<div class="link-details border-left border-color-grayLighter">

								<p><?php echo lang('navs.tree_explanation') ?></p>

							</div>

						</div>

					</div>
				

				<?php else:?>

					<div class="row-fluid">
				
						<div class="span6">

							<p class="alert margin"><?php echo lang('nav:group_no_links');?></p>

						</div>

						<div class="span6">

							<div class="link-details border-left border-color-grayLighter">


							</div>

						</div>

					</div>

				<?php endif ?>

			</section>
			<!-- /Box Content -->

		</section>
		<!-- /Box -->


	<?php endforeach ?>
	<?php else: ?>

		<!-- Box -->
		<section class="box">

			<!-- Header -->
			<section class="box-header">
				<span class="title"><?php echo lang('blog:posts_title') ?></span>
			</section>


			<!-- Box Content -->
			<section class="box-content">

				<p class="alert margin"><?php echo lang('nav:no_groups');?></p>

			</section>
			<!-- /Box Content -->

		</section>
		<!-- /Box -->

	<?php endif ?>


</div>
</section>