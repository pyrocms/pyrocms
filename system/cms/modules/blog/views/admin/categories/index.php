<div class="p n-p-b">
	<?php file_partial('notices'); ?>
</div>

<div class="p">

	<!-- .panel -->
	<section class="panel panel-default">

		<div class="panel-heading">
			<h3 class="panel-title">
				<?php echo lang('cat:list_title') ?>
			</h3>
		</div>

		<!-- .panel-body -->
		<div class="panel-body">


			<?php if ($categories): ?>

				<?php echo form_open('admin/blog/categories/delete') ?>

				<table class="table table-hover n-m">
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
							<td class="text-center">
								<?php echo anchor('admin/blog/categories/edit/'.$category->id, lang('global:edit'), 'class="btn-sm btn-warning edit"') ?>
								<?php echo anchor('admin/blog/categories/delete/'.$category->id, lang('global:delete'), 'class="confirm btn-sm btn-danger"') ;?>
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>


				<div class="panel-footer">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>

					<?php if(!empty($pagination['links'])): ?>
						<div class="paginate">
							<?php echo $pagination['links'];?>
						</div>
					<?php endif; ?>
				</div>


				<?php echo form_close() ?>

			<?php else: ?>
				<div class="alert alert-info"><?php echo lang('cat:no_categories') ?></div>
			<?php endif ?>


		</div>
		<!-- /.panel-body -->

	</section>
	<!-- /.panel -->

</div>