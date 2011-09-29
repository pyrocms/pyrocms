<?php if ($keywords): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th width="40%"><?php echo lang('keywords:name');?></th>
				<th width="200" class="align-center"><?php echo lang('action_label'); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($keywords as $keyword):?>
			<tr>
				<td><?php echo $keyword->name; ?></td>
				<td class="align-center buttons buttons-small">
				<?php echo anchor('admin/keywords/edit/'.$keyword->id, lang('global:edit'), 'class="button edit"'); ?>
				<?php if ( ! in_array($keyword->name, array('user', 'admin'))): ?>
					<?php echo anchor('admin/keywords/delete/'.$keyword->id, lang('global:delete'), 'class="confirm button delete"'); ?>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
	<section class="title"></section>
	<section class="item">
		<p><?php echo lang('keywords:no_keywords');?></p>
	</section>
<?php endif;?>