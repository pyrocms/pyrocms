<section class="content-wrapper">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<span class="title"><?php echo $module_details['name'] ?></span>
		</section>

		<div class="box-content">

			<?php if ($groups): ?>

				<table class="table table-hover table-bordered table-striped">
					<thead>
						<tr>
							<th width="40%"><?php echo lang('groups:name');?></th>
							<th><?php echo lang('groups:short_name');?></th>
							<th width="300"></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td colspan="3">
								<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					<?php foreach ($groups as $group):?>
						<tr>
							<td><?php echo $group->description ?></td>
							<td><?php echo $group->name ?></td>
							<td>

								<div class="btn-group pull-right">
									<?php echo anchor('admin/groups/edit/'.$group->id, lang('buttons:edit'), 'class="btn"') ?>
									<?php if ( ! in_array($group->name, array('user', 'admin'))): ?>
										<?php echo anchor('admin/groups/delete/'.$group->id, lang('buttons:delete'), 'class="confirm btn btn-danger"') ?>
									<?php endif ?>
									<?php echo anchor('admin/permissions/group/'.$group->id, lang('permissions:edit').' &rarr;', 'class="btn"') ?>
								</div>

							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			
			<?php else: ?>

				<p><?php echo lang('groups:no_groups');?></p>

			<?php endif;?>

		</div>

	</section>


</div>
</section>