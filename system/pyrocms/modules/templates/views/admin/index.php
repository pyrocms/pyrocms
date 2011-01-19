<?php if(!empty($templates)): ?>
    <?php echo form_open('admin/templates/action'); ?>
    
    <table border="0" class="table-list clear-both">
        <thead>
            <tr>
                <th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
                <th><?php echo 'Name'; ?></th>
                <th><?php echo 'Description'; ?></th>
                <th><?php echo 'Language'; ?></th>
                <th><?php echo 'Actions'; ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="5">
                    <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                </td>
            </tr>
        </tfoot>
        <tbody>
	
    <?php foreach ($templates as $template): ?>
            <tr>
				<td><?php echo form_checkbox('action_to[]', $template->id);?></td>
                <td><?php echo $template->name; ?></td>
                <td><?php echo $template->description; ?></td>
                <td><?php echo $template->lang; ?></td>
                <td>
                    <?php echo anchor('admin/templates/edit/' . $template->id, 'Edit'); ?>
                    <?php echo anchor('admin/templates/preview/' . $template->id, 'Preview'); ?>
                </td>
            </tr>
    <?php endforeach; ?>
    
        </tbody>
    </table>
    
    <?php echo form_close(); ?>
<?php else: ?>

<div class="blank-slate">
    <h2>No Templates</h2>  
</div>

<?php endif; ?>