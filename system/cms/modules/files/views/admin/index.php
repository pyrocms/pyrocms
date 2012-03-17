<section class="title">
	<h4><?php echo lang('files:files_title'); ?></h4>
</section>

<section class="item one_full">
	<section class="sidebar">
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

	<section class="two_third">
			<ul class="folders-center pane">
				<?php if ( ! $folders) : ?>
					<div class="no_data"><?php echo lang('files:no_folders'); ?></div>
				<?php endif; ?>
			</ul>

			<ul class="context-menu-source">
				<li 							data-applies-to="folder" 			data-menu="open"><?php echo lang('files:open'); ?></li>
				<li data-role="create_folder"	data-applies-to="pane root-pane"	data-menu="new-folder"><?php echo lang('files:new_folder'); ?></li>
				<li data-role="upload" 			data-applies-to="folder pane" 		data-menu="upload"><?php echo lang('files:upload'); ?></li>
				<li data-role="edit_file"		data-applies-to="file" 				data-menu="rename"><?php echo lang('files:rename'); ?></li>
				<li data-role="edit_folder"		data-applies-to="folder" 			data-menu="rename"><?php echo lang('files:rename'); ?></li>
				<!--<li 						data-applies-to="file" 				data-menu="edit"><?php echo lang('files:edit'); ?></li>-->
				<li data-role="download_file"	data-applies-to="file" 				data-menu="download"><?php echo lang('files:download'); ?></li>
				<li data-role="synchronize"		data-applies-to="folder"			data-menu="synchronize"><?php echo lang('files:synchronize'); ?></li>
				<li data-role="delete_file"		data-applies-to="file" 				data-menu="delete"><?php echo lang('files:delete'); ?></li>
				<li data-role="delete_folder"	data-applies-to="folder" 			data-menu="delete"><?php echo lang('files:delete'); ?></li>
				<li 							data-applies-to="folder file pane"	data-menu="details"><?php echo lang('files:details'); ?></li>
			</ul>
	</section>

	<section class="right sidebar">
		<ul class="console">
			<li class="right-title"><label for="file-search"><?php echo lang('files:search'); ?></label></li>
			<li class="right-title"><input type="text" id="file-search" name="file-search" value="" placeholder="<?php echo lang('files:search_message'); ?>"/>
				<ul class="search-results"></ul>
			</li>
			<li class="right-title console-title"><?php echo lang('files:activity'); ?></li>
		</ul>
	</section>

	<div class="hidden">
		<div id="files-uploader">
			
			<div class="files-uploader-browser">
				<?php echo form_open_multipart('admin/files/upload'); ?>
					<label for="file" class="upload"><?php echo lang('files:upload'); ?></label>
					<?php echo form_upload('file', NULL, 'multiple="multiple"'); ?>
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
					<span class="path"></span>
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
				<li><?php echo lang('files:download_count'); ?>: 
					<span class="download_count"></span>
				</li>
				<li><?php echo lang('files:location'); ?>: 
					<span class="location-static"></span>
				</li>
				<li><?php echo lang('files:container'); ?>: 
					<span class="container-static"></span>
				</li>
				<li><?php echo lang('files:location'); ?>: 
					<?php echo form_dropdown('location', $locations, '', 'class="location"'); ?>
				</li>
				<li><?php echo lang('files:bucket'); ?>: 
					<?php echo form_input('bucket', '', 'class="container amazon-s3"'); ?>
					<a class="container-button button"><?php echo lang('files:check_container'); ?></a>
				</li>
				<li><?php echo lang('files:container'); ?>: 
					<?php echo form_input('container', '', 'class="container rackspace-cf"'); ?>
					<a class="container-button button"><?php echo lang('files:check_container'); ?></a>
				</li>
				<li>
					<span class="container-info"></span>
				</li>
				<li><?php echo lang('files:description'); ?>: <br />
					<textarea class="description"></textarea>
				</li>
			</ul>
			<div class="buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
			</div>
		</div>

		<ul>
			<li class="new-folder" data-id="" data-name=""><span class="name-text"><?php echo lang('files:new_folder_name'); ?></span></li>
		</ul>
	</div>

</section>