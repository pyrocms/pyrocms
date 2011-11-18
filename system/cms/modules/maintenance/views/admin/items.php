<section class="title">
	<h4><?php echo lang('maintenance.list_label'); ?></h4>
</section>

<section class="item">

  <?php if ( ! empty($folders)): ?>
    <table border="0" class="table-list">
      <thead>
        <tr>
          <th><?php echo lang('name_label'); ?></th>
          <th class="align-center"><?php echo lang('maintenance.count_label'); ?></th>
          <th></th>
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
        <?php foreach ($folders as $folder): ?>
        <tr>
          <td><?php echo $folder->name; ?></td>
          <td class="align-center"><?php echo $folder->count; ?></td>
          <td class="buttons buttons-small align-center actions">
            <?php if ($folder->count > 0) echo anchor('admin/maintenance/cleanup/'.$folder->name, lang('global:empty'), array('class'=>'button empty')) ?>
            <?php if ( ! $folder->cannot_remove) echo anchor('admin/maintenance/cleanup/'.$folder->name.'/1', lang('global:remove'), array('class'=>'button remove')) ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="blank-slate">
      <h2><?php echo lang('maintenance.no_items'); ?></h2>
    </div>
  <?php endif;?>

</section>