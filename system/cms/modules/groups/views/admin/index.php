<section class="title">
	<h4><?php echo $module_details['name'] ?></h4>
</section>

<section class="item">
	<div class="content">
		<?php if ($groups): ?>
			<table class="table-list" cellspacing="0">
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
						<td class="actions">
						<?php echo anchor('admin/groups/edit/'.$group->id, lang('buttons:edit'), 'class="button edit"') ?>
						<?php if ( ! in_array($group->name, array('user', 'admin'))): ?>
							<?php echo anchor('admin/groups/delete/'.$group->id, lang('buttons:delete'), 'class="confirm button delete"') ?>
						<?php endif ?>
						<?php echo anchor('admin/permissions/group/'.$group->id, lang('permissions:edit').' &rarr;', 'class="button edit"') ?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		
		<?php else: ?>
			<section class="title">
				<p><?php echo lang('groups:no_groups');?></p>
			</section>
		<?php endif;?>
	</div>
</section>