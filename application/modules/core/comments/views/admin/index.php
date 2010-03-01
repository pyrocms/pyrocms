<?php $this->load->helper('date');?>  

<div class="box">

	<?php if($method == 'index'): ?>
		<h3><?php echo lang('comments.inactive_title');?></h3>
	<?php else: ?>
		<h3><?php echo lang('comments.active_title');?></h3>
	<?php endif; ?>
	
	<div class="box-container">
		
		<?php if (!empty($comments)): ?>
					
			<?php echo form_open('admin/comments/action');?>
				<?php echo form_hidden('redirect', $this->uri->uri_string()); ?> 
				<table border="0" class="table-list clear-both">    
					<thead>
						<tr>
							<th><?php echo form_checkbox('action_to_all');?></th>
							<th class="width-20"><?php echo lang('comments.teaser_label');?></th>
							<th class="width-10"><?php echo lang('comments.author_label');?></th>
							<th><?php echo lang('comments.date_label');?></th>
							<th><?php echo lang('comments.actions_label');?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td colspan="6">
								<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
							<?php foreach ($comments as $comment): ?>
								<tr>
									<td><?php echo form_checkbox('action_to[]', $comment->id);?></td>
									<td>
										<?php if( strlen($comment->comment) > 30 ): ?>
											<?php echo character_limiter($comment->comment, 30); ?>...
										<?php else: ?>
											<?php echo $comment->comment; ?>
										<?php endif; ?>
									</td>
									<td>
										<?php if($comment->user_id > 0): ?>
											<?php echo anchor('admin/users/edit/' . $comment->user_id, $comment->name); ?>
										<?php else: ?>
											<?php echo $comment->name;?>
										<?php endif; ?>
									</td>
									<td><?php echo date('M d, Y', $comment->created_on);?></td>						
									<td>
										<?php echo anchor('admin/comments/preview/'. $comment->id, lang('comments.preview_label'), 'rel="modal" target="_blank"'); ?> | 
										<?php if($comment->is_active == 0): ?>
											<?php echo anchor('admin/comments/approve/' . $comment->id, lang('comments.activate_label'),array('class' => 'ajax'));?>
										<?php else: ?>
											<?php echo anchor('admin/comments/unapprove/' . $comment->id, lang('comments.deactivate_label'),array('class' => 'ajax'));?>
										<?php endif; ?> | 
										<?php echo anchor('admin/comments/edit/' . $comment->id, lang('comments.edit_label'));?> | 
										<?php echo anchor('admin/comments/delete/' . $comment->id, lang('comments.delete_label'), array('class'=>'confirm')); ?>
									</td>
								</tr>
						<?php endforeach; ?>
					</tbody>	
				</table>
				
				<?php if( $method == 'index' ): ?>
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('approve','delete'))); ?>
				<?php else: ?>
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('unapprove','delete'))); ?>
				<?php endif; ?>
			<?php echo form_close();?>
	
		<?php else: ?>
			<p><?php echo lang('comments.no_comments');?></p>
		<?php endif; ?>
	</div>
</div>