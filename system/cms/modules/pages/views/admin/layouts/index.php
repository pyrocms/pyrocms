<section class="title">
	<h4><?php echo lang('page_layouts.list_title'); ?></h4>
</section>

<section class="item">
	<?php echo form_open('admin/pages/layouts/delete');?>
	
		<?php if ( ! empty($page_layouts)): ?>
			<table>		    
				<thead>
					<tr>
						<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
						<th><?php echo lang('page_layouts.title_label');?></th>
						<th><span><?php echo lang('page_layouts.actions_label');?></span></th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach ($page_layouts as $page_layout): ?>
						<tr>
							<td><?php echo form_checkbox('action_to[]', $page_layout->id); ?></td>
							<td><?php echo $page_layout->title;?></td>
							<td>
								<?php echo anchor('admin/pages/layouts/edit/' . $page_layout->id, lang('page_layouts.edit_label'));?> | 
								<?php echo anchor('admin/pages/layouts/delete/' . $page_layout->id, lang('page_layouts.delete_label'), array('class'=>'confirm'));?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
			<?php else:?>
				<p><?php echo lang('page_layouts.no_pages');?></p>
			<?php endif; ?>		
			
			<div>
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
			</div>
	
		<?php echo form_close(); ?>
</section>