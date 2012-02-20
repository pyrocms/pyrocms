<section class="title">
	<h4><?php echo lang('files:files_title'); ?></h4>
</section>

<section class="item">
	<section class="one_quarter">
			<ul class="folders-sidebar">
				<li class="places"><?php echo lang('files:places') ?></li>
				<?php if ($folders) : ?>
					<?php foreach ($folders as $folder): ?>
						<li class="folder"
							data-folder-id="<?php echo $folder->id.'" 
							data-folder-name="'.$folder->name.'" '.
							(strlen($folder->name) > 20 ? 'title="'.$folder->name.'">'.substr($folder->name, 0, 20).'...' : '>'.$folder->name); ?>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
	</section>

	<section class="one_half">
		<div class="files-navigation">
			<a class="back alignleft" href="<?php echo current_url();?>#"><?php echo lang('files:back');?></a>
			<a class="forward alignright" href="<?php echo current_url();?>#"><?php echo lang('files:forward');?></a>
		</div>
		<?php echo form_open().form_hidden('current-level', '0').form_close(); ?>
			<ul class="folders-right">
				<?php if ($folders) : ?>
					<?php foreach ($folders as $folder): ?>
						<li class="folder" 
							data-folder-id="<?php echo $folder->id.'" 
							data-folder-name="'.$folder->name.'">
								<span class="folder-text">'.$folder->name; ?></span>
						</li>
					<?php endforeach; ?>
				<?php else : ?>
					<div class="no_data"><?php echo lang('files:no_folders'); ?></div>
				<?php endif; ?>
			</ul>

			<ul class="context-menu-source">
				<li data-menu="open"><?php echo lang('files:open'); ?></li>
				<li data-menu="new-folder"><?php echo lang('files:new_folder'); ?></li>
				<li data-menu="upload" class="open-files-uploader"><?php echo lang('files:upload'); ?></li>
				<li data-menu="rename"><?php echo lang('files:rename'); ?></li>
				<li data-menu="edit"><?php echo lang('files:edit'); ?></li>
				<li data-menu="delete"><?php echo lang('files:delete'); ?></li>
				<li data-menu="details"><?php echo lang('files:details'); ?></li>
			</ul>
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

		<ul>
			<li class="new-folder" data-folder-id="" data-folder-name="" data-folder-slug=""><span class="folder-text"><?php echo lang('files:new_folder_name'); ?></span></li>
		</ul>
	</div>

</section>