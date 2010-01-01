<?php $this->load->helper('date');?>  

<div class="box">

	<?php if($active_comments): ?>
		<h3><?php echo lang('comments_active_title');?></h3>
	<?php else: ?>
		<h3><?php echo lang('comments_inactive_title');?></h3>
	<?php endif; ?>
	
	<div class="box-container">
	
	<?php echo form_open('admin/comments/action');?>
		<?php echo form_hidden('redirect', $this->uri->uri_string()); ?> 
		<table border="0" class="table-list clear-both">    
			<thead>
				<tr>
					<th><?php echo form_checkbox('action_to_all');?></th>
					<th class="width-20"><?php echo lang('comment_teaser_label');?></th>
					<th class="width-10"><?php echo lang('comment_author_label');?></th>
					<th class="width-10"><?php echo lang('comment_date_label');?></th>
					<th class="width-15"><?php echo lang('comment_actions_label');?></th>
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
			<?php if (!empty($comments)): ?>
					<?php foreach ($comments as $comment): ?>
						<tr>
							<td><?php echo form_checkbox('action_to[]', $comment->id);?></td>
							<td><?php echo character_limiter($comment->body, 30);?></td>
							<td>
								<?php if($comment->user_id > 0): ?>
									<?php echo anchor('admin/users/edit/' . $comment->user_id, $comment->name); ?>
								<?php else: ?>
									<?php echo $comment->name;?>
								<?php endif; ?>
							</td>
							<td><?php echo date('M d, Y', $comment->created_on);?></td>						
							<td>
								<?php echo anchor('admin/comments/preview/'. $comment->id, lang('comment_preview_label'), 'rel="modal" target="_blank"'); ?> | 
								<?php if($comment->is_active == 0): ?>
									<?php echo anchor('admin/comments/approve/' . $comment->id, lang('comment_activate_label'),array('class' => 'ajax'));?>
								<?php else: ?>
									<?php echo anchor('admin/comments/unapprove/' . $comment->id, lang('comment_deactivate_label'),array('class' => 'ajax'));?>
								<?php endif; ?> | 
								<?php echo anchor('admin/comments/edit/' . $comment->id, lang('comment_edit_label'));?> | 
								<?php echo anchor('admin/comments/delete/' . $comment->id, lang('comment_delete_label'), array('class'=>'confirm')); ?>
							</td>
						</tr>
				<?php endforeach; ?>
			<?php else: ?>
					<tr>
						<td colspan="6"><?php echo lang('comments_no_comments');?></td>
					</tr>
			<?php endif; ?>
			</tbody>	
		</table>
		
		<?php if( $method == 'index' ): ?>
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('approve','delete'))); ?>
		<?php else: ?>
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('unapprove','delete'))); ?>
		<?php endif; ?>
	<?php echo form_close();?>
	</div>
</div>