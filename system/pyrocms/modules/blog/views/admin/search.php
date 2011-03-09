<?php echo form_open('admin/blog/action');?>

<h3><?php echo lang('blog_list_title');?></h3>

<?php if (!empty($blog)): ?>

	<table border="0" class="table-list">
		<thead>
			<tr>
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th><?php echo lang('blog_post_label');?></th>
				<th class="width-10"><?php echo lang('blog_category_label');?></th>
				<th class="width-10"><?php echo lang('blog_date_label');?></th>
				<th class="width-5"><?php echo lang('blog_status_label');?></th>
				<th class="width-10"><span><?php echo lang('blog_actions_label');?></span></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					<div class="inner filtered"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($blog as $post): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $post->id);?></td>
					<td><?php echo $post->title;?></td>
					<td><?php echo $post->category_title;?></td>
					<td><?php echo format_date($post->created_on);?></td>
					<td><?php echo lang('blog_'.$post->status.'_label');?></td>
					<td>
						<?php echo anchor('admin/blog/preview/' . $post->id, lang($post->status == 'live' ? 'blog_view_label' : 'blog_preview_label'), 'rel="modal-large" class="iframe" target="_blank"') . ' | '; ?>
						<?php echo anchor('admin/blog/edit/' . $post->id, lang('blog_edit_label'));?> |
						<?php echo anchor('admin/blog/delete/' . $post->id, lang('blog_delete_label'), array('class'=>'confirm')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))); ?>
	</div>

<?php else: ?>
	<p><?php echo lang('blog_no_posts');?></p>
<?php endif; ?>

<?php echo form_close();?>