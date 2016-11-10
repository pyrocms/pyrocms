<?php if(!empty($templates)): ?>

<div class="accordion-group ">
<div class="accordion-heading">
		<h4><?php echo lang('templates:default_title') ?></h4>
	</div>
		
	<div class="accordion-body collapse in lst">
		<div class="content">
	
		    <?php echo form_open('admin/templates/action') ?>
		
		     <table class="table table-striped" cellspacing="0">
		        <thead>
		            <tr>
		                <th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
		                <th><?php echo lang('name_label') ?></th>
		                <th  ><?php echo lang('global:description') ?></th>
		                <th  ><?php echo lang('templates:language_label') ?></th>
		                <th width="220"></th>
		            </tr>
		        </thead>
		
		        <tbody>
				
		    <?php foreach ($templates as $template): ?>
				<?php if($template->is_default): ?>
		            <tr>
						<td><?php echo form_checkbox('action_to[]', $template->id);?></td>
		                <td><?php echo $template->name ?></td>
		                <td ><?php echo $template->description ?></td>
		                <td  ><?php echo $template->lang ?></td>
		                <td class="actions">
						<div class="buttons buttons-small align-center">
							<?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons:preview'), 'class="btn"') ?>
		                    <?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons:edit'), 'class="btn"') ?>
							<?php echo anchor('admin/templates/create_copy/' . $template->id, lang('buttons:clone'), 'class="btn"') ?>
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
	</div>
</div>

<div class="accordion-group ">
<div class="accordion-heading">
		<h4><?php echo lang('templates:user_defined_title') ?></h4>
	</div>
	
	<?php echo form_open('admin/templates/delete') ?>
	   
	<div class="accordion-body collapse in lst">
		<div class="content">
			<table class="table table-striped" cellspacing="0">
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
						<div class="buttons buttons-small align-center">
							<?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons:preview'), 'class="button preview modal btn"') ?>
		                    <?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons:edit'), 'class="button edit btn"') ?>
							<?php echo anchor('admin/templates/delete/' . $template->id, lang('buttons:delete'), 'class="button delete btn btn-danger"') ?>
						</div>
		                </td>
		            </tr>
				<?php endif ?>
		    <?php endforeach ?>
			
			
		        </tbody>
		    </table>
		
			<div class="table_action_buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
			</div>
		
		    <?php echo form_close() ?>
		</div>
	</div>
</div>
	
<?php else: ?>

<div class="accordion-group ">
<div class="accordion-heading">
		<div class="content">
	    <p><?php echo lang('templates:currently_no_templates') ?></p>
		</div>
	</div>
</div>

<?php endif ?>