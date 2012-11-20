<link href="<?php echo Asset::get_filepath_css('admin/files.css');?>" rel="stylesheet" />
<script src="<?php echo Asset::get_filepath_js('admin/file_picker.js');?>" type="text/javascript"></script>

<div style="display:none;">
    <div id="file-picker-<?php echo $field_id;?>" class="file-picker-modal" data-id="<?php echo $field_id;?>" is-multiple="<?php echo $multiple_select;?>">
        <div class="nav-bar buttons buttons-small">
            <?php echo form_button(lang('buttons.submit'), 'apply', 'class="button blue file-picker-apply-button"'); ?>
            <?php echo form_button(lang('buttons.close'), 'close', 'class="button red file-picker-close-button"'); ?>
        </div>
        <div class="side">
            <ul id="folders-sidebar">
                <li class="folder places" data-id="0"><a href="#"><?php echo lang('files:places') ?></a></li>
                <?php if ( ! $folders) : ?>
                <li class="no_data"><?php echo lang('files:no_folders_places'); ?></li>
                <?php elseif ($folder_tree) : ?>
                <?php echo tree_builder($folder_tree, '<li class="folder" data-id="{{ id }}" data-name="{{ name }}"><div></div><a href="#">{{ name }}</a>{{ children }}</li>'); ?>
                <?php endif; ?>
            </ul>
        </div>

        <div class="right-side">
            <?php if ( ! $folders) : ?>
            <div class="no_data"><?php echo lang('files:no_folders'); ?></div>
            <?php endif; ?>
            <ul class="folders-center pane"></ul>
        </div>

        <div class="clearfix"> </div>
    </div>

</div>