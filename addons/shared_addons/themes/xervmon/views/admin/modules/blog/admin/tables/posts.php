	<table cellspacing="0" class="table table-striped">
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
				<th><?php echo lang('blog:post_label') ?></th>
				<th class="collapse"><?php echo lang('blog:category_label') ?></th>
				<th class="collapse"><?php echo lang('blog:date_label') ?></th>
				<th class="collapse"><?php echo lang('blog:written_by_label') ?></th>
				<th><?php echo lang('blog:status_label') ?></th>
				<th width="180"><?php echo lang('global:actions') ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($blog as $post) : ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $post->id) ?></td>
					<td><?php echo $post->title ?></td>
					<td class="collapse"><?php echo $post->category_title ?></td>
					<td class="collapse"><?php echo format_date($post->created_on) ?></td>
					<td class="collapse">
					<?php if (isset($post->display_name)): ?>
						<?php echo anchor('user/'.$post->username, $post->display_name, 'target="_blank"') ?>
					<?php else: ?>
						<?php echo lang('blog:author_unknown') ?>
					<?php endif ?>
					</td>
					<td><?php echo lang('blog:'.$post->status.'_label') ?></td>
					<td style="padding-top:10px;">
                        <?php if($post->status=='live') : ?>
							<a href="<?php echo site_url('blog/'.date('Y/m', $post->created_on).'/'.$post->slug) ?>" title="<?php echo lang('global:view')?>" class=" ti btn" target="_blank" style="margin-right:8px;">View</a>
                        <?php else: ?>
							<a href="<?php echo site_url('blog/preview/' . $post->preview_hash) ?>" title="<?php echo lang('global:preview')?>" class=" ti btn" target="_blank" style="margin-right:8px;">Preview</a>
                        <?php endif ?>
						<a href="<?php echo site_url('admin/blog/edit/' . $post->id) ?>" title="<?php echo lang('global:edit')?>" class=" edit ti btn" style="margin-right:6px;">Edit</a>
						<a href="<?php echo site_url('admin/blog/delete/' . $post->id) ?>" class="confirm delete ti btn btn-danger">Delete</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))) ?>
            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('publish'))) ?>
	</div>