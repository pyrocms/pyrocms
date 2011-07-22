<?php if(!empty($templates)): ?>
    <?php echo form_open('admin/templates/action'); ?>
    
    <table border="0" class="table-list clear-both">
        <thead>
			<tr>
				<th colspan="5"><?php echo lang('templates.default_title'); ?></th>
			</tr>
            <tr>
                <th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
                <th><?php echo lang('templates.name_label'); ?></th>
                <th><?php echo lang('templates.description_label'); ?></th>
                <th><?php echo lang('templates.language_label'); ?></th>
                <th width="350" class="align-center"><?php echo lang('templates.actions_label'); ?></th>
            </tr>
        </thead>
        
        <tbody>
		
    <?php foreach ($templates as $template): ?>
		<?php if($template->is_default): ?>
            <tr>
				<td><?php echo form_checkbox('action_to[]', $template->id);?></td>
                <td><?php echo $template->name; ?></td>
                <td><?php echo $template->description; ?></td>
                <td><?php echo $template->lang; ?></td>
                <td>
				<div class="buttons buttons-small align-center">
					<?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons.preview'), 'class="button preview modal"'); ?>
                    <?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons.edit'), 'class="button edit"'); ?>
					<?php echo anchor('admin/templates/create_copy/' . $template->id, lang('buttons.clone'), 'class="button clone"'); ?>
				</div>
                </td>
            </tr>
		<?php endif; ?>
    <?php endforeach; ?>
	</tbody>
	</table>
    <?php echo form_close(); ?>
    <?php echo form_open('admin/templates/delete'); ?>
	
	<table border="0" class="table-list clear-both">
        <thead>
			<tr>
				<th colspan="5"><?php echo lang('templates.user_defined_title'); ?></th>
			</tr>
            <tr>
                <th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
                <th><?php echo lang('templates.name_label'); ?></th>
                <th><?php echo lang('templates.description_label'); ?></th>
                <th><?php echo lang('templates.language_label'); ?></th>
                <th width="350" class="align-center"><?php echo lang('templates.actions_label'); ?></th>
            </tr>
        </thead>
        
        <tbody>
	
    <?php foreach ($templates as $template): ?>
		<?php if(!$template->is_default): ?>
            <tr>
				<td><?php echo form_checkbox('action_to[]', $template->id);?></td>
                <td><?php echo $template->name; ?></td>
                <td><?php echo $template->description; ?></td>
                <td><?php echo $template->lang; ?></td>
                <td>
				<div class="buttons buttons-small align-center">
					<?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons.preview'), 'class="button preview"'); ?>
                    <?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons.edit'), 'class="button edit"'); ?>
					<?php echo anchor('admin/templates/delete/' . $template->id, lang('buttons.delete'), 'class="button delete"'); ?>
				</div>
                </td>
            </tr>
		<?php endif; ?>
    <?php endforeach; ?>
	
	
        </tbody>
    </table>

	<div class="buttons padding-top align-right">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
	</div>
    
    <?php echo form_close(); ?>
<?php else: ?>

<div class="blank-slate">
    <h2><?php echo lang('templates.currently_no_templates'); ?></h2>
</div>

<?php endif; ?>