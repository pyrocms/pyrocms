<section class="title">
	<h4><?php echo $module_details['name'] ?></h4>
</section>

<section class="item">
<div class="content">

<?php if ($keywords): ?>
    <table class="table-list" cellspacing="0">
		<thead>
			<tr>
				<th width="40%"><?php echo lang('keywords:name');?></th>
				<th width="200"></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($keywords as $keyword):?>
			<tr>
				<td><?php echo $keyword->name ?></td>
				<td class="actions">
				<?php echo anchor('admin/keywords/edit/'.$keyword->id, lang('global:edit'), 'class="button edit"') ?>
				<?php if ( ! in_array($keyword->name, array('user', 'admin'))): ?>
					<?php echo anchor('admin/keywords/delete/'.$keyword->id, lang('global:delete'), 'class="confirm button delete"') ?>
				<?php endif ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
	<div class="no_data"><?php echo lang('keywords:no_keywords');?></div>
<?php endif;?>

</div>
</section>