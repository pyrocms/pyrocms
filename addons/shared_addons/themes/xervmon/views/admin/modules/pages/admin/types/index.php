<div class="accordion-group">
<section class="title accordion-heading">
	<h4><?php echo lang('page_types:list_title'); ?></h4>
</section>

<section class="item accordion-body collapse in lst">
	<div class="content">
		<?php echo form_open('admin/pages/types/delete');?>
		
			<?php if ( ! empty($page_types)): ?>
				<table border="0" cellspacing="0" class="table table-striped">		    
					<thead>
						<tr>
							<th><?php echo lang('global:title');?></th>
							<th></th>
						</tr>
					</thead>
					
					<tbody>
						<?php foreach ($page_types as $page_type): ?>
							<tr>
								<td><?php echo $page_type->title;?></td>
								<td class="actions">
	
									<?php if ($page_type->save_as_files == 'y' and $page_type->needs_sync): ?>
									<?php echo anchor('admin/pages/types/sync/'.$page_type->id, lang('page_types:sync_files'), array('class'=>'button btn'));?> 
									<?php endif; ?>
	
									<?php echo anchor('admin/pages/types/fields/'.$page_type->id, lang('global:fields'), array('class'=>'button btn'));?> 
									<?php echo anchor('admin/pages/types/edit/' . $page_type->id, lang('global:edit'), array('class'=>'button btn'));?> 
									<?php echo anchor('admin/pages/types/delete/' . $page_type->id, lang('global:delete'), array('class'=>'button btn'));?>
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
    </div>