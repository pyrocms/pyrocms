<?php if (Settings::get('moderate_comments')): ?>
<h3><?php echo $content_title;?></h3>
<?php endif; ?>

<?php if ( ! empty($comments)): ?>

	<?php echo form_open('admin/comments/action');?>
		<?php echo form_hidden('redirect', uri_string()); ?>
		<table border="0" class="table-list clear-both">
			<thead>
				<tr>
					<th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
					<th width="25%"><?php echo lang('comments.message_label');?></th>
					<th><?php echo lang('comments.item_label');?></th>
					<th><?php echo lang('comments.author_label');?></th>
					<th><?php echo lang('comments.email_label');?></th>
					<th width="80"><?php echo lang('comments.date_label');?></th>
					<th width="<?php echo Settings::get('moderate_comments') ? '320': '220'; ?>" class="align-center"><?php echo lang('comments.actions_label');?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="7">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($comments as $comment): ?>
					<tr>
						<td><?php echo form_checkbox('action_to[]', $comment->id);?></td>
						<td>
							<a href="<?php echo site_url('admin/comments/preview/'. $comment->id); ?>" rel="modal" target="_blank">
								<?php if( strlen($comment->comment) > 30 ): ?>
									<?php echo character_limiter($comment->comment, 30); ?>
								<?php else: ?>
									<?php echo $comment->comment; ?>
								<?php endif; ?>
							</a>
						</td>
						<td><?php echo isset($comment->item) ? $comment->item : '???'; ?></td>
						<td>
							<?php if($comment->user_id > 0): ?>
								<?php echo anchor('admin/users/edit/' . $comment->user_id, $comment->name); ?>
							<?php else: ?>
								<?php echo $comment->name;?>
							<?php endif; ?>
						</td>
						<td><?php echo mailto($comment->email);?></td>
						<td><?php echo format_date($comment->created_on);?></td>
						<td class="align-center buttons buttons-small">
							<?php if ($this->settings->moderate_comments): ?>
							<?php if($comment->is_active): ?>
								<?php echo anchor('admin/comments/unapprove/' . $comment->id, lang('comments.deactivate_label'), 'class="button deactivate"'); ?>
							<?php else: ?>
								<?php echo anchor('admin/comments/approve/' . $comment->id, lang('comments.activate_label'), 'class="button activate"'); ?>
							<?php endif; ?>
							<?php endif; ?>
							<?php echo anchor('admin/comments/edit/' . $comment->id, lang('comments.edit_label'), 'class="button edit"'); ?>
							<?php echo anchor('admin/comments/delete/' . $comment->id, lang('comments.delete_label'), array('class'=>'confirm button delete')); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="buttons align-right padding-top">
		<?php if (Settings::get('moderate_comments')): ?>
			<?php if ( ! $comments_active): ?>
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('approve','delete'))); ?>
			<?php else: ?>
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('unapprove','delete'))); ?>
			<?php endif; ?>
		<?php else: ?>
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
		<?php endif; ?>
		</div>

	<?php echo form_close();?>

<?php else: ?>
	<div class="blank-slate">
		<?php echo image('icons/comments.png'); ?>
	
		<h2><?php echo lang('comments.no_comments');?></h2>
	</div>
<?php endif; ?>