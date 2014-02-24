<section class="title">
    <h4><?php echo lang('global:field_types');?></h4>
</section>

<section class="item">
<div class="content">

<?php foreach ($modes as $key => $mode): ?>

    <h2><?php echo lang("addons:plugins:{$key}_field_types") ?></h2>

    <table class="table-list" cellspacing="0">
        <thead>
            <tr>
                <th><?php echo lang('name_label');?></th>
                <th><?php echo lang('version_label');?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($mode as $type): ?>
        <tr>
            <td width="60%"><?php echo $type['name'] ?>
            <td><?php echo $type['version'] ?>
        </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php endforeach; ?>

</div>
</section>
