<section class="title">
	<h4><?php echo lang('files:files_title'); ?></h4>
</section>

<section class="item">
	<section class="one_quarter">
			<ul class="folders-sidebar">
				<li class="folder places" data-id="0"><a href="#"><?php echo lang('files:places') ?></a></li>
				<?php if ($folder_tree) : ?>
					<?php foreach ($folder_tree as $folder): ?>
						<li class="folder"
							data-id="<?php echo $folder['id'].'" 
							data-name="'.$folder['name'].'" '.
							(strlen($folder['name']) > 20 ? 'title="'.$folder['name'].'"><a href="#">'.substr($folder['name'], 0, 20).'...</a>' : '><a href="#">'.$folder['name']); ?></a>
							<?php if (isset($folder['children'])): ?>
								<ul style="display:none" >
									<?php $admin->sidebar($folder); ?>
								</ul>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
	</section>

	<section class="one_half">
			<ul class="folders-right pane">
				<?php if ( ! $folders) : ?>
					<div class="no_data"><?php echo lang('files:no_folders'); ?></div>
				<?php endif; ?>
			</ul>

			<ul class="context-menu-source">
				<li data-applies-to="folder" 						data-menu="open"><?php echo lang('files:open'); ?></li>
				<li data-applies-to="pane root-pane"				data-menu="new-folder"><?php echo lang('files:new_folder'); ?></li>
				<li data-applies-to="folder pane" 					data-menu="upload"><?php echo lang('files:upload'); ?></li>
				<li data-applies-to="folder file" 					data-menu="rename"><?php echo lang('files:rename'); ?></li>
				<li data-applies-to="file" 							data-menu="edit"><?php echo lang('files:edit'); ?></li>
				<li data-applies-to="folder file" 					data-menu="delete"><?php echo lang('files:delete'); ?></li>
				<li data-applies-to="folder file pane root-pane"	data-menu="details"><?php echo lang('files:details'); ?></li>
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

		<div class="item-details">
			<h4><?php echo lang('files:details'); ?></h4>
			<ul>
				<li><?php echo lang('files:name'); ?>: 
					<span class="name"></span>
				</li>
				<li><?php echo lang('files:slug'); ?>: 
					<span class="slug"></span>
				</li>
				<li><?php echo lang('files:path'); ?>: 
					<span class="path">http://bucket.s3.amazon.com/this/is/the/object.jpg</span>
				</li>
				<li><?php echo lang('files:added'); ?>: 
					<span class="added"></span>
				</li>
				<li><?php echo lang('files:width'); ?>: 
					<span class="width"></span>
				</li>
				<li><?php echo lang('files:height'); ?>: 
					<span class="height"></span>
				</li>
				<li><?php echo lang('files:filename'); ?>: 
					<span class="filename"></span>
				</li>
				<li><?php echo lang('files:filesize'); ?>: 
					<span class="filesize"></span>
				</li>
				<li><?php echo lang('files:description'); ?>: <br />
					<textarea class="description"></textarea>
				</li>
			</ul>
		</div>

		<ul>
			<li class="new-folder" data-id="" data-name=""><span class="name-text"><?php echo lang('files:new_folder_name'); ?></span></li>
		</ul>
	</div>

</section>