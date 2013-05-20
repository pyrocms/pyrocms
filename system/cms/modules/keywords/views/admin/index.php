<section class="padded">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<span class="title"><?php echo $module_details['name'] ?></h4>
		</section>

		<div class="padded">

		<?php if ($keywords): ?>
		    <table class="table table-hover table-bordered table-striped">
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
						<td>
							<div class="pull-right btn-group">
								<?php echo anchor('admin/keywords/edit/'.$keyword->id, lang('global:edit'), 'class="btn"') ?>
								<?php if ( ! in_array($keyword->name, array('user', 'admin'))): ?>
									<?php echo anchor('admin/keywords/delete/'.$keyword->id, lang('global:delete'), 'class="confirm btn btn-danger"') ?>
								<?php endif ?>
							</div>

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


</div>
</section>