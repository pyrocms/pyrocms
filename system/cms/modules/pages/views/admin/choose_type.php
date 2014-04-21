<section class="title">
        <h4><?php echo lang('pages:choose_type_title');?></h4>
</section>

<section class="item">
    <div class="content">
        <table border="0" cellspacing="0">
            <thead>
                <th width="20%"><?php echo lang('global:title');?></th>
                <th><?php echo lang('global:description');?></th>
                <th width="20%"></th>
            </thead>
            <tbody>
                <?php foreach ($types as $type): ?>
                <tr>
                    <td>
                        <?php echo anchor('admin/pages/create?page_type='.$type->id.$parent, $type->title);?>
                    </td>
                    <td>
                        <?php echo $type->description;?>
                    </td>
                    <td class="actions">
                        <?php echo anchor('admin/pages/create?page_type='.$type->id.$parent, Lang('pages:create_title'), array('class'=>'button'));?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
