<!DOCTYPE html>
<html>
<head>
	<title><?php echo lang('cp_admin_title').' - '.$template['title'];?></title>

	<!-- Grab Google CDNs jQuery, fall back if necessary -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?php echo base_url(); ?>system/pyrocms/assets/js/jquery/jquery-1.4.2.min.js"><\/script>')</script>

	<?php echo $template['partials']['metadata']; ?>
	<style type="text/css">
	body {
		background: none;
	}
	</style>
</head>

<body>
	<?php $this->load->view('admin/partials/notices') ?>
	<?php echo $template['body']; ?>
</body>
</html>
