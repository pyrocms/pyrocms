<?php echo form_open('admin/files/folders/delete/' . $folder->id); ?>
<h2><?php echo lang('files.folders.delete_title'); ?></h2>
<p><?php echo sprintf(lang('files.folders.confirm_delete'), $folder->name); ?></p>
<?php echo form_submit('button_action', lang('buttons.yes'), 'class="pyro-button"'); ?>&nbsp;
<?php echo form_submit('button_action', lang('buttons.no'), 'class="pyro-button"'); ?>

<?php echo form_close(); ?>
