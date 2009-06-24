<? $this->load->helper('date');?>      
<?= form_open($this->uri->uri_string());?>
	<?=form_hidden('redirect', $this->uri->uri_string()); ?> 
	<table border="0" class="listTable">    
		<thead>
			<tr>
				<th class="first"><div></div></th>
				<th class="width-10"><a href="#"><?=lang('comments_status_label');?></a></th>
				<th class="width-10"><a href="#"><?=lang('comments_author_label');?></a></th>
				<th class="width-10"><a href="#"><?=lang('comments_date_label');?></a></th>
				<th class="last width-10"><span><?=lang('comments_actions_label');?></span></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					<div class="inner"><? $this->load->view('admin/layout_fragments/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<? if (!empty($comments)): ?>
				<? foreach ($comments as $comment): ?>
					<tr>
						<td><input type="checkbox" name="action_to[]" value="<?=$comment->id;?>" /></td>
						<td>
							<? if($comment->active == 0): ?>
								<?=anchor('admin/comments/activate/' . $comment->id, lang('comments_activate_label'));?>
							<? else: ?>
								<?=anchor('admin/comments/deactivate/' . $comment->id, lang('comments_deactivate_label'));?>
							<? endif; ?>
						</td>
						<td><?=$comment->name;?></td>
						<td><?=date('M d, Y', $comment->created_on);?></td>						
						<td>
							<?= anchor('admin/comments/preview/'. $comment->id, lang('comments_preview_label'), 'rel="modal" target="_blank"'); ?><br />
							<?= anchor('admin/comments/edit/' . $comment->id, lang('comments_edit_label'));?> | 
							<?= anchor('admin/comments/delete/' . $comment->id, lang('comments_delete_label'), array('class'=>'confirm')); ?>
						</td>
					</tr>
			<? endforeach; ?>
		<? else: ?>
				<tr>
					<td colspan="6"><?=lang('comments_no_comments');?></td>
				</tr>
		<? endif; ?>
		</tbody>	
	</table>
	<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?=form_close();?>
