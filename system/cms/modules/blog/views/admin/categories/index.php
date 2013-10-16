<div class="p">


	<section id="page-title">
		<h1><?php echo lang('cat:list_title') ?></h1>
	</section>


	<!-- .panel -->
	<section class="panel panel-default">
	
		<!-- .panel-content -->
		<div class="panel-content">


			<?php if ($categories): ?>

				<?php echo form_open('admin/blog/categories/delete') ?>

				<table class="table n-m">
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

					
				<?php if(!empty($pagination['links'])): ?>
					<div class="paginate">
						<?php echo $pagination['links'];?>
					</div>
				<?php endif; ?>


				<div class="panel-footer">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
				</div>

				<?php echo form_close() ?>

			<?php else: ?>
				<div class="no_data padding"><?php echo lang('cat:no_categories') ?></div>
			<?php endif ?>


		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>