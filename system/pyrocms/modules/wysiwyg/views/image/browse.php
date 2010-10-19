<?php echo form_open_multipart('cms/wysiwyg/image/upload'); ?>
    <input type="hidden" name="MAX_FILE_SIZE" value="2048000" />

    <ul class="crud">
        <li>
            <label for="folder_id">Folder</label>
            <select name="folder_id" size="1">
                <option value="">-- None --</option>
                <?php create_tree_select($folder_options, 0, 0, set_value('folder_id')); ?>
            </select>
        </li>

        <li>
            <label for="title">Title</label>
            <?php echo form_input('title', set_value('title')); ?>
        </li>

        <li>
            <label for="image">Image</label>
            <?php echo form_upload('image', set_value('image')); ?>
        </li>

        <li>
            <label for="status">Status</label>
            <?php echo form_dropdown('status', array('live'=> lang('status.live'), 'hold'=> lang('status.hold')), set_value('status')); ?>
        </li>
    </ul>

    <div class="buttons label-offset">
        <button type="submit" name="save" value="" class="positive"><?php echo image('icons/black/16/round_plus.png'); ?><?php echo lang('button.upload');?></button>
    </div>
    <div class="clear"></div>
<?php echo form_close(); ?>
<br /><br />
	
<?php echo form_open('cms/wysiwyg/image/browse');?>

	<ul class="filter">
            <li>
                <label for="folder_id">Filter by folder</label>
                <select name="folder_id" size="1">
                    <option value="">-- All --</option>
                    <?php echo create_tree_select($folder_options, 0, 0, set_value('folder_id')); ?>
                </select>
            </li>
            <li>
                <label for="status">Status</label>
                <?php echo form_dropdown('status', array(
                    '' => '-- All --',
                    'hold'=> lang('status.hold'),
                    'live'=> lang('status.live'),
                    'deleted'=> lang('status.deleted')),
                set_value('status')); ?>
            </li>
            <li>
                <label for="hide_folders">Hide folders?</label>
                <?php echo form_checkbox('hide_folders', 1, set_value('hide_folders') == 1); ?>
            </li>
            <li>
                <label for="q">Keywords</label>
                <?php echo form_input('q', set_value('q')); ?>
                <?php echo form_submit('filter', 'Go'); ?>
            </li>
	</ul>

	<br style="clear:both"/>

<?php echo form_close(); ?>

<ul class="breadcrumb">
    <li>
        <strong><?php echo anchor('cms/wysiwyg/image/browse', '&raquo; Root'); ?></strong>
    </li>
    <?php foreach( $breadcrumbs as $crumb ): ?>
    <li>
        <?php echo anchor('cms/wysiwyg/image/browse/folder/' . $crumb->id, "&raquo; " . $crumb->title); ?>
    </li>
    <?php endforeach; ?>
    <div class="clear"></div>
</ul>

<br style="clear:both"/>

<?php if (!empty($images)): ?>

	<?php foreach ($images as $image): ?>

		<?php if($image->is_folder): ?>
			<div class="image folder">
				<?php echo anchor('cms/wysiwyg/image/browse/' . $criteria_uri . 'folder/' . $image->id, image('icons/black/32/folder_arrow.png'));?>
				<h4><?php echo anchor('cms/wysiwyg/image/browse/' . $criteria_uri . 'folder/' . $image->id, $image->title); ?></h4>
			</div>

		<?php else: ?>
			<div class="image">
				<?php echo form_open('cms/wysiwyg/image', NULL, array(
					'title' => $image->title, 'source' => $image->filename, 'folder_id' => $image->folder_id,
					'width' => $image->width, 'height' => $image->height
				)); ?>

				<h4><?php echo $image->title; ?></h4>

				<img src="<?php echo SITE_UPLOAD_URI . 'images/' . $image->thumb; ?>" alt="" width="160" />

				<?php if($image->status == 'live'): ?>
					<div class="buttons">
						<button type="submit" name="insert-image" value=""><?php echo image('icons/black/16/round_plus.png'); ?>Insert</button>
						<p style="float: right;"><?php echo $image->width . ' x ' . $image->height; ?>
						<br /><strong><?php echo lang('status.'.$image->status); ?></strong></p>
					</div>
					<div class="clear"></div>
				<?php endif; ?>

				<?php echo form_close(); ?>
			</div>
		<?php endif; ?>

		<?php echo alternator('', '', '', '<br style="clear:both;" />');?>
	<?php endforeach; ?>

	<br style="clear:both;" />

<?php else: ?>
    <p>No images found.</p>
<?php endif;?>