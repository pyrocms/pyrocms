<section class="title">
	<h4><?php echo lang('page_types:list_title'); ?></h4>
</section>

<section class="item">
	<div class="content">
		<?php echo form_open('admin/pages/types/delete');?>
		
			<?php if ( ! empty($page_types)): ?>
				<table border="0" cellspacing="0">		    
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
								<td class="actions">
	
									<?php if ($page_type->save_as_files == 'y' and $page_type->needs_sync): ?>
									<?php echo anchor('admin/pages/types/sync/'.$page_type->id, lang('page_types:sync_files'), array('class'=>'button'));?> 
									<?php endif; ?>
	
									<?php echo anchor('admin/pages/types/fields/'.$page_type->id, lang('global:fields'), array('class'=>'button'));?> 
									<?php echo anchor('admin/pages/types/edit/' . $page_type->id, lang('global:edit'), array('class'=>'button'));?> 
									<?php if ($page_type->slug !== 'default') echo anchor('admin/pages/types/delete/' . $page_type->id, lang('global:delete'), array('class'=>'button'));?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				
				<?php else:?>
					<div class="no_data"><?php echo lang('page_types:no_pages');?></div>
				<?php endif; ?>		
				
			<?php echo form_close(); ?>
	</div>
</section>