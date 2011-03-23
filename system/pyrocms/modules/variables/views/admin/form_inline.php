<?php echo form_open($this->uri->uri_string(), 'class="crud" id="variables"'); ?>
<td><?php echo form_checkbox('action_to[]', $variable->id); ?></td>
    <td>
        <?php echo  form_input('name', $variable->name); ?>
    </td>
    <td>
        <?php echo  form_input('data', $variable->data); ?>
    </td>
    <td>
        <?php form_input('', printf('{%s:variables:%s}', config_item('tags_trigger'), $variable->name));?>
        <?php echo form_hidden('variable_id', $variable->id); ?>
    </td>
    <td class="align-center buttons buttons-small actions">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>  
    </td>
<?php echo form_close(); ?>