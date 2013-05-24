<section class="content-wrapper">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<span class="title"><?php echo lang('page_types:list_title'); ?></span>
		</section>

		<div class="box-content">
			
			<?php echo form_open('admin/pages/types/delete');?>
			
				<?php if ( ! empty($page_types)): ?>
					<table class="table" border="0" cellspacing="0">		    
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
									<td>

										<div class="btn-group">
											<?php if ($page_type->save_as_files == 'y' and $page_type->needs_sync): ?>
											<?php echo anchor('admin/pages/types/sync/'.$page_type->id, lang('page_types:sync_files'), array('class'=>'btn'));?> 
											<?php endif; ?>
			
											<?php echo anchor('admin/pages/types/fields/'.$page_type->id, lang('global:fields'), array('class'=>'btn'));?> 
											<?php echo anchor('admin/pages/types/edit/' . $page_type->id, lang('global:edit'), array('class'=>'btn'));?> 
											<?php if ($page_type->slug !== 'default') echo anchor('admin/pages/types/delete/' . $page_type->id, lang('global:delete'), array('class'=>'btn btn-danger'));?>
										</div>

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
</section>