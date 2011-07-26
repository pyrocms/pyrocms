<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo lang('error_404_title'); ?></title>
<style type="text/css">

body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
}

#content  {
border:				#999 1px solid;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		normal;
font-size:			14px;
color:				#990000;
margin: 			0 0 4px 0;
}
</style>
</head>
<body>
	<div id="content">
		<h1><?php echo lang('error_404_title'); ?></h1>
		<?php echo sprintf(lang('error_404_message'), site_url('')); ?>
	</div>
</body>
</html>