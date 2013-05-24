<section class="content-wrapper">
<div class="container-fluid">


	<?php if(!empty($templates)): ?>

	<div class="row-fluid">
			
		<section class="box">

			<section class="box-header">
				<span class="title"><?php echo lang('templates:default_title') ?></span>
			</section>

			<div class="box-content">
		
			    <?php echo form_open('admin/templates/action') ?>
			
			    <table class="table table-hover table-bordered table-striped">
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
									<?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons:preview'), 'class="btn"') ?>
				                    <?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons:edit'), 'class="btn edit"') ?>
									<?php echo anchor('admin/templates/create_copy/' . $template->id, lang('buttons:clone'), 'class="btn clone"') ?>
								</div>

			                </td>
			            </tr>
					<?php endif ?>
			    <?php endforeach ?>
				</tbody>
				</table>
			    <?php echo form_close() ?>
			 
			 	<div class="table_action_buttons">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
				</div>
			</div>

		</section>

	</div>

	

	<div class="row-fluid">
		
		<?php echo form_open('admin/templates/delete') ?>
		   
		<section class="box">

			<section class="box-header">
				<span class="title"><?php echo lang('templates:user_defined_title') ?></span>
			</section>

			<div class="box-content">
				
				<table class="table table-hover table-bordered table-striped">
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
			                <td>
								
								<div class="buttons buttons-small align-center">
									<?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons:preview'), 'class="button modal"') ?>
				                    <?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons:edit'), 'class="button"') ?>
									<?php echo anchor('admin/templates/delete/' . $template->id, lang('buttons:delete'), 'class="button delete"') ?>
								</div>

			                </td>
			            </tr>
					<?php endif ?>
			    <?php endforeach ?>
				
				
			        </tbody>
			    </table>
			
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
			
			    <?php echo form_close() ?>
			</div>

		</section>

	</div>

		
	<?php else: ?>

	<div class="one_full">
		<section class="item">
			<div class="content">
		    <p><?php echo lang('templates:currently_no_templates') ?></p>
			</div>
		</section>
	</div>

	<?php endif ?>


</div>
</section>