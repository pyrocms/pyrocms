<section class="title">
	<h4><?php echo lang('page_types.list_title'); ?></h4>
</section>

<section class="item">
	<?php echo form_open('admin/pages/types/delete');?>
	
		<?php if ( ! empty($page_types)): ?>
			<table>		    
				<thead>
					<tr>
						<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
						<th><?php echo lang('global:title');?></th>
						<th></th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach ($page_types as $page_type): ?>
						<tr>
							<td><?php echo form_checkbox('action_to[]', $page_type->id); ?></td>
							<td><?php echo $page_type->title;?></td>
							<td class="actions">
								<?php echo anchor('admin/pages/types/edit/' . $page_type->id, lang('global:edit'), array('class'=>'button'));?> 
								<?php echo anchor('admin/pages/types/delete/' . $page_type->id, lang('global:delete'), array('class'=>'button confirm'));?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="table_action_buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
			</div>
			
			<?php else:?>
				<div class="no_data"><?php echo lang('page_types.no_pages');?></div>
			<?php endif; ?>		
			
		<?php echo form_close(); ?>
</section>