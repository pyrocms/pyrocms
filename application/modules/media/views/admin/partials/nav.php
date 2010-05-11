<style type="text/css">
div#media-nav ul {
	margin: 0 0 15px 0;
}
div#media-nav ul li {
	display: inline;
}
div#media-nav ul li a {
	padding: 5px 10px;
}
div#media-nav ul li a.current {
	padding: 5px 10px;
	font-weight: bold;
}
</style>

<div id="media-nav">
	<ul>
		<li><?php echo anchor('admin/media/images', lang('media.images.title'), ($method == 'images' || $method == 'index') ? 'class="current"' : ''); ?></li>
		<li><?php echo anchor('admin/media/documents', lang('media.documents.title'), ($method == 'documents') ? 'class="current"' : ''); ?></li>
		<li><?php echo anchor('admin/media/video', lang('media.video.title'), ($method == 'videos') ? 'class="current"' : ''); ?></li>
		<li><?php echo anchor('admin/media/audio', lang('media.audio.title'), ($method == 'audio') ? 'class="current"' : ''); ?></li>
	</ul>
</div>
