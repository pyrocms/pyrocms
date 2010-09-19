<script type="text/javascript">

function insertFile(id, title)
{
	insertHtml('<a class="pyro-document" href="' + '<?php echo site_url(); ?>files/download/' + id + '">' + title + '</a>');
    windowClose();
}

</script>

<p>Browse about, find the right document then use insertFile(id, title) to get the file download link done.</p>

<input type="button" onclick="insertFile(1, 'Example');" value="Example" />