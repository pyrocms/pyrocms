<section class="title">
	<h4 id="file-title">
		<?php echo lang('files:files_title') ?>
	</h4>

	<div id="file-toolbar">
		<div id="file-buttons">
			<ul class="button-menu-source buttons">
				<li class="button animated fadeIn" data-applies-to="pane root-pane"	data-menu="refresh"><?php echo lang('files:refresh') ?></li>
				<li class="button animated fadeIn" data-applies-to="folder" data-menu="open"><?php echo lang('files:open') ?></li>
				<li class="button animated fadeIn" data-role="create_folder"	data-applies-to="pane root-pane" data-menu="new-folder"><?php echo lang('files:new_folder') ?></li>
				<li class="button animated fadeIn" data-role="upload" data-applies-to="folder pane" data-menu="upload"><?php echo lang('files:upload') ?></li>
				<li class="button animated fadeIn" data-role="edit_file" data-applies-to="file" data-menu="rename"><?php echo lang('files:rename') ?></li>
				<li class="button animated fadeIn" data-role="edit_folder" data-applies-to="folder" data-menu="rename"><?php echo lang('files:rename') ?></li>
				<li class="button animated fadeIn" data-role="download_file" data-applies-to="file" data-menu="download"><?php echo lang('files:download') ?></li>
				<li class="button animated fadeIn" data-role="synchronize" data-applies-to="folder" data-menu="synchronize"><?php echo lang('files:synchronize') ?></li>
				<li class="button animated fadeIn" data-role="upload delete_file" data-applies-to="file" data-menu="replace"><?php echo lang('files:replace') ?></li>
				<li class="button animated fadeIn" data-role="delete_file" data-applies-to="file" data-menu="delete"><?php echo lang('files:delete') ?></li>
				<li class="button animated fadeIn" data-role="delete_folder" data-applies-to="folder" data-menu="delete"><?php echo lang('files:delete') ?></li>
				<li class="button animated fadeIn" data-applies-to="folder file pane"	data-menu="details"><?php echo lang('files:details') ?></li>
			</ul>
		</div>
		<input type="text" id="file-search" name="file-search" value="" placeholder="<?php echo lang('files:search_message') ?>"/>
	</div>
</section>

<section class="item">
	<section class="side">
		<ul id="folders-sidebar">
			<li class="folder places" data-id="0"><a href="#"><?php echo lang('files:places') ?></a></li>
			<?php if ( ! $folders) : ?>
				<li class="no_data"><?php echo lang('files:no_folders_places') ?></li>
			<?php elseif ($folder_tree) : ?>
				<?php echo tree_builder($folder_tree, '<li class="folder" data-id="{{ id }}" data-name="{{ name }}"><div></div><a href="#">{{ name }}</a>{{ children }}</li>') ?>
			<?php endif ?>
		</ul>
	</section>

	<section class="center">

			<?php if ( ! $folders) : ?>
				<div class="no_data"><?php echo lang('files:no_folders') ?></div>
			<?php endif ?>

			<ul class="folders-center pane"></ul>

			<ul class="context-menu-source">
				<li data-applies-to="folder" data-menu="open"><?php echo lang('files:open') ?></li>
				<li data-role="create_folder"	data-applies-to="pane root-pane" data-menu="new-folder"><?php echo lang('files:new_folder') ?></li>
				<li data-role="upload" data-applies-to="folder pane" data-menu="upload"><?php echo lang('files:upload') ?></li>
				<li data-role="edit_file" data-applies-to="file" data-menu="rename"><?php echo lang('files:rename') ?></li>
				<li data-role="upload delete_file" data-applies-to="file" data-menu="replace"><?php echo lang('files:replace') ?></li>
				<li data-role="edit_folder"	data-applies-to="folder" data-menu="rename"><?php echo lang('files:rename') ?></li>
				<!--<li data-applies-to="file" data-menu="edit"><?php echo lang('files:edit') ?></li>-->
				<li data-role="download_file"	data-applies-to="file" data-menu="download"><?php echo lang('files:download') ?></li>
				<li data-role="synchronize"	data-applies-to="folder" data-menu="synchronize"><?php echo lang('files:synchronize') ?></li>
				<li data-role="delete_file"	data-applies-to="file" data-menu="delete"><?php echo lang('files:delete') ?></li>
				<li data-role="delete_folder"	data-applies-to="folder" data-menu="delete"><?php echo lang('files:delete') ?></li>
				<li data-applies-to="folder file pane" data-menu="details"><?php echo lang('files:details') ?></li>
			</ul>

	</section>

	<section class="side sidebar-right animated" id="file-sidebar">
		<button class="close" alt="close">Close</button>
		<ul id="search-results"></ul>
	</section>

	<div class="hidden">
		
		<script type="text/javascript">

			/*
			 * Put this somewhere safe
			 * - Like at the end of the document
			 */

			$('body').append('<div class="hidden"><div id="files-uploader"><div id="file-to-replace"><h4><?php echo lang("files:replace_file")?>:<span class="name"></span></h4><span class="alert-warning"><?php echo lang("files:replace_warning")?></span></div><div class="files-uploader-browser"><form action="<?php echo site_url('admin/files/upload'); ?>"method="post"accept-charset="utf-8"enctype="multipart/form-data"><label for="file"class="upload"><?php echo lang("files:uploader")?></label><input type="file"name="file"value=""multiple="multiple"/><input type="hidden"name="replace-id"value=""/></form><div class="buttons"><a href="#"title=""class="button start-upload"><?php echo lang("files:upload")?></a><a href="#"title=""class="button cancel-upload"><?php echo lang("buttons:cancel");?></a></div><ul id="files-uploader-queue"class="ui-corner-all"></ul></div></div></div>');
			
		</script>

		<div id="item-details">
			<h4><?php echo lang('files:details') ?></h4>
			<ul>
				<li><label><?php echo lang('files:id') ?>:</label> 
					<span class="id"></span>
				</li>
				<li><label><?php echo lang('files:name') ?>:</label> 
					<span class="name"></span>
				</li>

				<li class="show-data">
					<button><?php echo lang('files:toggle_data_display') ?></button>
				</li>
			</ul>

			<ul class="meta-data">
				<li><label><?php echo lang('files:slug') ?>:</label> 
					<span class="slug"></span>
				</li>
				<li><label><?php echo lang('files:path') ?>:</label> 
					<input readonly="readonly" type="text" class="path"/>
				</li>
				<li><label><?php echo lang('files:added') ?>:</label> 
					<span class="added"></span>
				</li>
				<li><label><?php echo lang('files:width') ?>:</label> 
					<span class="width"></span>
				</li>
				<li><label><?php echo lang('files:height') ?>:</label> 
					<span class="height"></span>
				</li>
				<li><label><?php echo lang('files:filename') ?>:</label> 
					<span class="filename"></span>
				</li>
				<li><label><?php echo lang('files:filesize') ?>:</label> 
					<span class="filesize"></span>
				</li>
				<li><label><?php echo lang('files:download_count') ?>:</label> 
					<span class="download_count"></span>
				</li>
				<li><label><?php echo lang('files:location') ?>:</label> 
					<span class="location-static"></span>
				</li>
				<li><label><?php echo lang('files:container') ?>:</label> 
					<span class="container-static"></span>
				</li>
				<li><label><?php echo lang('files:location') ?>:</label> 
					<?php echo form_dropdown('location', $locations, '', 'class="location"') ?>
				</li>
				<li><label><?php echo lang('files:bucket') ?>:</label> 
					<?php echo form_input('bucket', '', 'class="container amazon-s3"') ?>
					<a class="container-button button"><?php echo lang('files:check_container') ?></a>
				</li>
				<li><label><?php echo lang('files:container') ?>:</label> 
					<?php echo form_input('container', '', 'class="container rackspace-cf"') ?>
					<a class="container-button button"><?php echo lang('files:check_container') ?></a>
				</li>
				<li>
					<span class="container-info"></span>
				</li>
			</ul>

			<ul class="item-description">
				<li><label><?php echo lang('files:alt_attribute') ?>:</label>
					<input type="text" class="alt_attribute" />
				</li>
				<li><label><?php echo lang('files:keywords') ?>:</label>
					<?php echo form_input('keywords', '', 'id="keyword_input"') ?>
				</li>
				<li><label><?php echo lang('files:description') ?>:</label> <br />
					<textarea class="description"></textarea>
				</li>
			</ul>
			<div class="buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>
		</div>

		<ul>
			<li class="new-folder" data-id="" data-name=""><span class="name-text"><?php echo lang('files:new_folder_name') ?></span></li>
		</ul>
	</div>

</section>

<section class="file-path">
	<h5 id="file-breadcrumbs">
		<span id="crumb-root">
			<a data-id="0" href="#"><?php echo lang('files:places') ?></a>
		</span>
	</h5>
	<h5 id="activity"></h5>
</section>
