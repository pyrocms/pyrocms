<section class="padded">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<span class="title"><?php echo lang('cat:list_title') ?></span>
		</section>

		<div class="padded">
		
			<?php if ($categories): ?>

				<?php echo form_open('admin/blog/categories/delete') ?>

				<table border="0" class="table table-hover">
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
							<td class="align-center">

								<div class="btn-group">
									<?php echo anchor('admin/blog/categories/edit/'.$category->id, lang('global:edit'), 'class="btn edit"') ?>
									<?php echo anchor('admin/blog/categories/delete/'.$category->id, lang('global:delete'), 'class="confirm btn btn-danger"') ;?>
								</div>

							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>

				<?php $this->load->view('admin/partials/pagination') ?>

				<div class="table_action_buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
				</div>

				<?php echo form_close() ?>

			<?php else: ?>
				<div class="no_data"><?php echo lang('cat:no_categories') ?></div>
			<?php endif ?>

		</div>
	</section>


</div>
</section>