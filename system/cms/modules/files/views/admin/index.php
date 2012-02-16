<section class="title">
	<h4><?php echo lang('files:files_title'); ?></h4>
</section>

<section class="item">
	<section class="one_quarter">
		<?php if ($folders) : ?>

			<ul class="folders-sidebar">
				<li class="places"><?php echo lang('files:places') ?></li>
				<?php foreach ($folders as $folder): ?>
					<li data-slug="<?php echo $folder->slug.'" '.
						(strlen($folder->name) > 20 ? 'title="'.$folder->name.'">'.substr($folder->name, 0, 20).'...' : '>'.$folder->name); ?>
					</li>
				<?php endforeach; ?>
			</ul>

		<?php endif; ?>
	</section>

	<section class="one_half">
		<?php if ($folders) : ?>

			<ul class="folders-right">
				<?php foreach ($folders as $folder): ?>
					<li class="folder" data-slug="<?php echo $folder->slug.'"><span class="folder-text">'.$folder->name; ?></span></li>
				<?php endforeach; ?>
			</ul>

			<ul class="context-menu-source">
				<li data-menu="upload" class="open-files-uploader"><?php echo lang('files:upload'); ?></li>
				<li data-menu="rename"><?php echo lang('files:rename'); ?></li>
				<li data-menu="edit"><?php echo lang('files:edit'); ?></li>
				<li data-menu="delete"><?php echo lang('files:delete'); ?></li>
				<li data-menu="details"><?php echo lang('files:details'); ?></li>
			</ul>
		<?php else : ?>
			<div class="no_data"><?php echo lang('files:no_folders'); ?></div>
		<?php endif; ?>
	</section>

	<section class="right one_quarter">
		<ul class="console">
			<li class="console-title"><?php echo lang('files:activity'); ?></li>
		</ul>
	</section>

	<div class="hidden">
		<div id="files-uploader">
			
			<div class="files-uploader-browser">
				<?php echo form_open_multipart('admin/files/upload'); ?>
				<label for="userfile" class="upload"><?php echo lang('files.upload_title'); ?></label>
					<?php echo form_upload('userfile', NULL, 'multiple="multiple"'); ?>
				<?php echo form_close(); ?>
				<ul id="files-uploader-queue" class="ui-corner-all"></ul>
			</div>
			
			<div class="buttons align-right padding-top">
				<a href="#" title="" class="button start-upload"><?php echo lang('files:upload'); ?></a>
				<a href="#" title="" class="button cancel-upload"><?php echo lang('buttons.cancel');?></a>
			</div>
			
		</div>
	</div>

</section>