<?php echo form_open('admin/media/folders/delete/' . $folder->id); ?>
<h2><?php echo lang('media.folders.delete_title'); ?></h2>
<p><?php echo sprintf(lang('media.folders.confirm_delete'), $folder->name); ?></p>
<?php echo form_submit('button_action', lang('buttons.yes'), 'class="button"'); ?>&nbsp;
<?php echo form_submit('button_action', lang('buttons.no'), 'class="button"'); ?>

<?php echo form_close(); ?>
