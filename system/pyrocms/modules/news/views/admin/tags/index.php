<h3><?php echo lang('tag_list_title');?></h3>

<?php echo form_open('admin/news/tags/delete'); ?>
    <table border="0" class="table-list">
        <thead>
        <tr>
            <th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
            <th><?php echo lang('tag_tag_label');?></th>
            <th class="width-10"><span><?php echo lang('tag_actions_label');?></span></th>
        </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="3">
                    <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                </td>
            </tr>
        </tfoot>
        <tbody>
        <?php if ($tags): ?>
            <?php foreach ($tags as $tag): ?>
            <tr>
                <td><?php echo form_checkbox('action_to[]', $tag->id); ?></td>
                <td><?php echo $tag->tag;?></td>
                <td>
                    <?php echo anchor('admin/news/tags/edit/' . $tag->id, lang('tag_edit_label')) . ' | '; ?>
                    <?php echo anchor('admin/news/tags/delete/' . $tag->id, lang('tag_delete_label'), array('class'=>'confirm'));?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3"><?php echo lang('tag_no_tags');?></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close(); ?>