<div class="p n-p-b">
	<?php file_partial('notices'); ?>
</div>

<div class="p">


	<!-- .panel -->
	<section class="panel panel-default">


		<div class="panel-heading">
			<h3 class="panel-title">
				<?php echo lang('page_types:list_title'); ?>
			</h3>
		</div>


		<?php echo form_open('admin/pages/types/delete');?>

			<?php if ( ! empty($page_types)): ?>
				<table class="table n-m">
					<thead>
						<tr>
                            <th width="20%"><?php echo lang('global:title');?></th>
                            <th width="50%"><?php echo lang('global:description');?></th>
                            <th width="30%"></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($page_types as $page_type): ?>
							<tr>
								<td><?php echo $page_type->title;?></td>
                                <td><?php echo $page_type->description;?></td>
								<td class="text-right">

									<?php if ($page_type->save_as_files == 'y' and $page_type->needs_sync): ?>
									<?php echo anchor('admin/pages/types/sync/'.$page_type->id, lang('page_types:sync_files'), array('class'=>'btn-sm btn-default'));?>
									<?php endif; ?>

									<?php echo anchor('admin/pages/types/fields/'.$page_type->id, lang('global:fields'), array('class'=>'btn-sm btn-default'));?>
									<?php echo anchor('admin/pages/types/edit/' . $page_type->id, lang('global:edit'), array('class'=>'btn-sm btn-warning'));?>
									<?php if ($page_type->slug !== 'default') echo anchor('admin/pages/types/delete/' . $page_type->id, lang('global:delete'), array('class'=>'btn-sm btn-danger confirm'));?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php else:?>
					<div class="alert alert-info m"><?php echo lang('page_types:no_pages');?></div>
				<?php endif; ?>

			<?php echo form_close(); ?>

	</section>
	<!-- /.panel -->

</div>