<?php if(!empty($templates)): ?>

<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo lang('templates:default_title') ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


		    <?php echo form_open('admin/templates/action') ?>
		
		    <table class="table table-hover table-striped">
		        <thead>
		            <tr>
		                <th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
		                <th><?php echo lang('name_label') ?></th>
		                <th class="collapse"><?php echo lang('global:description') ?></th>
		                <th class="collapse"><?php echo lang('templates:language_label') ?></th>
		                <th width="220"></th>
		            </tr>
		        </thead>
		
		        <tbody>
				
		    <?php foreach ($templates as $template): ?>
				<?php if($template->is_default): ?>
		            <tr>
						<td><?php echo form_checkbox('action_to[]', $template->id);?></td>
		                <td><?php echo $template->name ?></td>
		                <td class="collapse"><?php echo $template->description ?></td>
		                <td class="collapse"><?php echo $template->lang ?></td>
		                <td>

							<div class="btn-group pull-right">
								<?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons:preview'), 'class="btn btn-small" data-toggle="modal"') ?>
								<?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons:edit'), 'class="btn btn-small btn-warning"') ?>
								<?php echo anchor('admin/templates/create_copy/' . $template->id, lang('buttons:clone'), 'class="btn btn-small"') ?>
							</div>
		                </td>
		            </tr>
				<?php endif ?>
		    <?php endforeach ?>
			</tbody>
			</table>
		    <?php echo form_close() ?>
		 
		 	<div class="btn-group padded no-padding-top">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
			</div>
		

		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->




	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo lang('templates:user_defined_title') ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php echo form_open('admin/templates/delete') ?>
		   
				<table class="table table-hover table-striped clear-both">
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
						<?php if(!$template->is_default): ?>
				            <tr>
								<td><?php echo form_checkbox('action_to[]', $template->id);?></td>
				                <td><?php echo $template->name ?></td>
				                <td><?php echo $template->description ?></td>
				                <td><?php echo $template->lang ?></td>
				                <td class="actions">

									<div class="btn-group pull-right">
										<?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons:preview'), 'class="btn btn-small" data-toggle="modal"') ?>
										<?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons:edit'), 'class="btn btn-small btn-warning"') ?>
										<?php echo anchor('admin/templates/delete/' . $template->id, lang('buttons:delete'), 'class="btn btn-small btn-danger"') ?>
									</div>

				                </td>
				            </tr>
						<?php endif ?>
				    <?php endforeach ?>
					
					
			        </tbody>
			    </table>
			
				<div class="btn-group padding-left padding-right">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
				</div>
			
			<?php echo form_close() ?>

		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->


</div>
</section>

<?php else: ?>

	<!-- Box -->
	<section class="box">

		<!-- Box Content -->
		<section class="box-content">

		    <p class="alert margin"><?php echo lang('templates:currently_no_templates') ?></p>

		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->		   


<?php endif ?>