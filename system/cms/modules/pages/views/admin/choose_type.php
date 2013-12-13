<div class="modal-dialog">
<div class="modal-content">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo lang('pages:choose_type_title');?></h4>
    </div>
    
    <div class="modal-body">
        <table border="0" cellspacing="0">
            <thead>
                <th width="20%"><?php echo lang('global:title');?></th>
                <th><?php echo lang('global:description');?></th>
                <th width="20%"></th>
            </thead>
            <tbody>
                <?php foreach ($page_types as $pt): ?>
                <tr>
                    <td>
                        <?php echo anchor('admin/pages/create?page_type='.$pt->id.$parent, $pt->title);?>
                    </td>
                    <td>
                        <?php echo $pt->description;?>
                    </td>
                    <td class="actions">
                        <?php echo anchor('admin/pages/create?page_type='.$pt->id.$parent, Lang('pages:create_title'), array('class'=>'button'));?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
</div>