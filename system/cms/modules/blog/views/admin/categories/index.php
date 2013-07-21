<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo lang('cat:list_title') ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php if ($categories): ?>

				<?php echo form_open('admin/blog/categories/delete') ?>

				<table class="table table-hover table-striped">
					<thead>
					<tr>
						<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
						<th><?php echo lang('cat:category_label') ?></th>
						<th><?php echo lang('global:slug') ?></th>
						<th width="120"></th>
					</tr>
					</thead>
					<tbody>
						<?php foreach ($categories as $category): ?>
						<tr>
							<td><?php echo form_checkbox('action_to[]', $category->id) ?></td>
							<td><?php echo $category->title ?></td>
							<td><?php echo $category->slug ?></td>
							<td>

								<div class="pull-right">
									<?php echo anchor('admin/blog/categories/edit/'.$category->id, lang('global:edit'), 'class="btn btn-small btn-warning"') ?>
									<?php echo anchor('admin/blog/categories/delete/'.$category->id, lang('global:delete'), 'class="confirm btn btn-small btn-danger"') ;?>
								</div>

							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>

				<?php $this->load->view('admin/partials/pagination') ?>

				<div class="padding-left padding-right">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
				</div>

				<?php echo form_close() ?>

			<?php else: ?>
				<div class="alert margin"><?php echo lang('cat:no_categories') ?></div>
			<?php endif ?>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>