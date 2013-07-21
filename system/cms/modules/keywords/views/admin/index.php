<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo $module_details['name'] ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php if ($keywords): ?>
			    <table class="table table-hover table-striped">
					
					<thead>
						<tr>
							<th width="40%"><?php echo lang('keywords:name');?></th>
							<th width="200"></th>
						</tr>
					</thead>
					
					<tbody>
					<?php foreach ($keywords as $keyword):?>
						<tr>
							<td><?php echo $keyword->name ?></td>
							<td>

								<div class="btn-group pull-right">
									<?php echo anchor('admin/keywords/edit/'.$keyword->id, lang('global:edit'), 'class="btn btn-small btn-warning edit"') ?>
									<?php if ( ! in_array($keyword->name, array('user', 'admin'))): ?>
										<?php echo anchor('admin/keywords/delete/'.$keyword->id, lang('global:delete'), 'class="confirm btn btn-small btn-danger"') ?>
									<?php endif ?>
								</div>

							</td>
						</tr>
					<?php endforeach;?>
					</tbody>

			    </table>

			<?php else: ?>
				<div class="alert margin"><?php echo lang('keywords:no_keywords');?></div>
			<?php endif;?>


			<?php $this->load->view('admin/partials/pagination') ?>
			

		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>