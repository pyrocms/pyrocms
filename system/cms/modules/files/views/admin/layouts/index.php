<div class="hidden">
	<div id="fileupload">
		<?php echo form_open_multipart('admin/files/upload'); ?>
			<!-- Input / DropZone-->
			<label class="fileinput-button small ui-corner-all">
				<span><?php echo lang('files.upload_title'); ?></span>
				<?php echo form_upload('userfile[]', NULL, 'class="no-uniform" multiple="multiple"'); ?>
			</label>
			<!-- Content -->
			<div class="fileupload-content">
				<div class="files-wrapper ui-corner-all">
					<table class="files"></table>
				</div>
				<div class="fileupload-progressbar"></div>
			</div>
			<!-- Buttons -->
			<div class="buttons align-right fileupload-buttonbar">
				<button type="submit" class="start"><span>Start upload</span></button>
				<button type="reset" class="cancel"><span>Cancel upload</span></button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div id="files-browser">
	<nav id="files-browser-nav">
		<?php echo $template['partials']['nav']; ?>
	</nav>
	<div id="files-browser-contents">
		<?php echo $content; ?>
	</div>
</div>

<script id="template-upload" type="text/x-jquery-tmpl">
    <tr class="template-upload{{if error}} upload-error{{/if}}">
        <td class="preview"></td>
        <td class="name">
			${name}
			<input type="hidden" name="name[]" value="${name}" />
		</td>
        <td class="size align-center">${sizef}</td>
        {{if error}}
            <td class="message">
                {{if error === 'maxFileSize'}}File is too big
                {{else error === 'minFileSize'}}File is too small
                {{else error === 'acceptFileTypes'}}Filetype not allowed
                {{else error === 'maxNumberOfFiles'}}Max number of files exceeded
                {{else}}${error}
                {{/if}}
            </td>
			<td class="buttons buttons-small">
				<button class="cancel"><span>Cancel</span></button>
			</td>
        {{else}}
            <td class="progress"><div></div></td>
            <td class="buttons buttons-small align-center">
				<button class="start"><span>Start</span></button>
				<button class="cancel"><span>Cancel</span></button>
			</td>
        {{/if}}
    </tr>
</script>
<script id="template-download" type="text/x-jquery-tmpl">
    <tr class="template-download{{if error}} upload-error{{/if}}">
        {{if error}}
            <td class="preview"></td>
            <td class="name">${name}</td>
            <td class="size align-center">${sizef}</td>
            <td class="message">
                {{if error === 1}}File exceeds upload_max_filesize (php.ini directive)
                {{else error === 2}}File exceeds MAX_FILE_SIZE (HTML form directive)
                {{else error === 3}}File was only partially uploaded
                {{else error === 4}}No File was uploaded
                {{else error === 5}}Missing a temporary folder
                {{else error === 6}}Failed to write file to disk
                {{else error === 7}}File upload stopped by extension
                {{else error === 'maxFileSize'}}File is too big
                {{else error === 'minFileSize'}}File is too small
                {{else error === 'acceptFileTypes'}}Filetype not allowed
                {{else error === 'maxNumberOfFiles'}}Max number of files exceeded
                {{else error === 'uploadedBytes'}}Uploaded bytes exceed file size
                {{else error === 'emptyResult'}}Empty file upload result
                {{else}}${error}
                {{/if}}
            </td>
        {{else}}
            <td class="preview">
                {{if thumbnail_url}}
				<div class="wrapper ui-corner-all">
					<a href="${url}" target="_blank" class="inner ui-corner-all"><img src="${thumbnail_url}"></a>
				</div>
                {{/if}}
            </td>
            <td class="name">
                <a href="${url}"{{if thumbnail_url}} target="_blank"{{/if}}>${name}</a>
            </td>
            <td class="size align-center" colspan="2">${sizef}</td>
        {{/if}}
        <td class="buttons buttons-small align-center">
            <button class="delete" data-type="${delete_type}" data-url="${delete_url}"><span>Delete</span></button>
        </td>
    </tr>
</script>