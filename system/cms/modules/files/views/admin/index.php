<section class="title">
	<h4><?php echo lang('files:files_title'); ?></h4>
</section>

<section class="item one_full">
	<section class="sidebar">
		<ul id="folders-sidebar">
			<li class="folder places" data-id="0"><a href="#"><?php echo lang('files:places') ?></a></li>
			<?php if ( ! $folders) : ?>
				<li class="no_data"><?php echo lang('files:no_folders_places'); ?></li>
			<?php elseif ($folder_tree) : ?>
				<?php echo tree_builder($folder_tree, '<li class="folder" data-id="{{ id }}" data-name="{{ name }}"><div></div><a href="#">{{ name }}</a>{{ children }}</li>'); ?>
			<?php endif; ?>
		</ul>
	</section>

	<section class="two_third">
			<?php if ( ! $folders) : ?>
				<div class="no_data"><?php echo lang('files:no_folders'); ?></div>
			<?php endif; ?>

			<ul class="folders-center pane"></ul>

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

	<section class="right sidebar sidebar-left">
		<div id="search-area">
			<span class="subsection-title"><?php echo lang('files:search'); ?></span>
			<input type="text" id="file-search" name="file-search" value="" placeholder="<?php echo lang('files:search_message'); ?>"/>
			<ul id="search-results"></ul>
		</div>
		<div id="console-area">
			<span class="subsection-title"><?php echo lang('files:activity'); ?></span>
			<ul id="console"></ul>
		</div>

	</section>

	<div class="hidden">
		<div id="files-uploader">
			
			<div class="files-uploader-browser">
				<?php echo form_open_multipart('admin/files/upload'); ?>
					<label for="file" class="upload"><?php echo lang('files:uploader'); ?></label>
					<?php echo form_upload('file', NULL, 'multiple="multiple"'); ?>
				<?php echo form_close(); ?>
				<ul id="files-uploader-queue" class="ui-corner-all"></ul>
			</div>
			
			<div class="buttons align-right padding-top">
				<a href="#" title="" class="button start-upload"><?php echo lang('files:upload'); ?></a>
				<a href="#" title="" class="button cancel-upload"><?php echo lang('buttons.cancel');?></a>
			</div>
			
		</div>

		<div id="item-details">
			<h4><?php echo lang('files:details'); ?></h4>
			<ul>
				<li><label><?php echo lang('files:id'); ?>:</label> 
					<span class="id"></span>
				</li>
				<li><label><?php echo lang('files:name'); ?>:</label> 
					<span class="name"></span>
				</li>
				<li><label><?php echo lang('files:slug'); ?>:</label> 
					<span class="slug"></span>
				</li>
				<li><label><?php echo lang('files:path'); ?>:</label> 
					<input readonly="readonly" type="text" class="path"/>
				</li>
				<li><label><?php echo lang('files:added'); ?>:</label> 
					<span class="added"></span>
				</li>
				<li><label><?php echo lang('files:width'); ?>:</label> 
					<span class="width"></span>
				</li>
				<li><label><?php echo lang('files:height'); ?>:</label> 
					<span class="height"></span>
				</li>
				<li><label><?php echo lang('files:filename'); ?>:</label> 
					<span class="filename"></span>
				</li>
				<li><label><?php echo lang('files:filesize'); ?>:</label> 
					<span class="filesize"></span>
				</li>
				<li><label><?php echo lang('files:download_count'); ?>:</label> 
					<span class="download_count"></span>
				</li>
				<li><label><?php echo lang('files:location'); ?>:</label> 
					<span class="location-static"></span>
				</li>
				<li><label><?php echo lang('files:container'); ?>:</label> 
					<span class="container-static"></span>
				</li>
				<li><label><?php echo lang('files:location'); ?>:</label> 
					<?php echo form_dropdown('location', $locations, '', 'class="location"'); ?>
				</li>
				<li><label><?php echo lang('files:bucket'); ?>:</label> 
					<?php echo form_input('bucket', '', 'class="container amazon-s3"'); ?>
					<a class="container-button button"><?php echo lang('files:check_container'); ?></a>
				</li>
				<li><label><?php echo lang('files:container'); ?>:</label> 
					<?php echo form_input('container', '', 'class="container rackspace-cf"'); ?>
					<a class="container-button button"><?php echo lang('files:check_container'); ?></a>
				</li>
				<li>
					<span class="container-info"></span>
				</li>
				<li><label><?php echo lang('files:description'); ?>:</label> <br />
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