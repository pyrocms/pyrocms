<div class="p">


	<section id="page-title">
		<h1><?php echo lang('templates:default_title') ?></h1>
	</section>


	<!-- .panel -->
	<section class="panel panel-default">

		<div class="panel-heading">
			<h3 class="panel-title"><?php echo lang('templates:default_title') ?></h3>
		</div>


		<!-- .panel-content -->
		<div class="panel-content">


		    <table class="table n-m">
		        <thead>
		            <tr>
		                <th><?php echo lang('name_label') ?></th>
		                <th class="collapse"><?php echo lang('global:description') ?></th>
		                <th class="collapse"><?php echo lang('templates:language_label') ?></th>
		                <th width="220"></th>
		            </tr>
		        </thead>

		        <tbody>

		    <?php foreach ($default_templates as $template): ?>
		            <tr>
		                <td><?php echo $template->name ?></td>
		                <td class="collapse"><?php echo $template->description ?></td>
		                <td class="collapse"><?php echo $template->lang ?></td>
		                <td class="text-right">
							<?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons:preview'), 'class="btn btn-xs btn-default" data-toggle="modal" data-target="#modal"') ?>
							<?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons:edit'), 'class="btn btn-xs btn-warning"') ?>
							<?php echo anchor('admin/templates/create_copy/' . $template->id, lang('buttons:clone'), 'class="btn btn-xs btn-default"') ?>
		                </td>
		            </tr>
		    <?php endforeach ?>
			</tbody>
			</table>

		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->



	<!-- .panel -->
	<section class="panel panel-default">

		<div class="panel-heading">
			<h3 class="panel-title"><?php echo lang('templates:user_defined_title') ?></h3>
		</div>


		<!-- .panel-content -->
		<div class="panel-content">


			<?php if(! $templates->isEmpty()): ?>
			
				<?php echo form_open('admin/templates/delete') ?>

				
					<table class="table n-m">
				        <thead>
				            <tr>
				                <th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				                <th><?php echo lang('name_label') ?></th>
				                <th><?php echo lang('global:description') ?></th>
				                <th><?php echo lang('templates:language_label') ?></th>
				                <th width="220"></th>
				            </tr>
				        </thead>

				        <tbody>

					    <?php foreach ($templates as $template): ?>
					            <tr>
									<td><?php echo form_checkbox('action_to[]', $template->id);?></td>
					                <td><?php echo $template->name ?></td>
					                <td><?php echo $template->description ?></td>
					                <td><?php echo $template->lang ?></td>
					                <td class="text-right">
										<?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons:preview'), 'class="btn btn-xs btn-default" data-toggle="modal" data-target="#modal"') ?>
										<?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons:edit'), 'class="btn btn-xs btn-warning"') ?>
										<?php echo anchor('admin/templates/delete/' . $template->id, lang('buttons:delete'), 'class="btn btn-xs btn-danger confirm"') ?>
									</div>
					                </td>
					            </tr>
					    <?php endforeach ?>
				        </tbody>
				    </table>

					<div class="panel-footer">
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
					</div>

				  <?php echo form_close() ?>

			<?php else: ?>

				<div class="panel-footer"><?php echo lang('templates:currently_no_templates') ?></div>
				
			<?php endif ?>


		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>