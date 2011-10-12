<!doctype html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> 		   <![endif]-->

<head>
	<meta charset="utf-8">

  	<!-- You can use .htaccess and remove these lines to avoid edge case issues. -->
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  	<title><?php echo lang('cp_admin_title').' - '.$template['title'];?></title>

	<base href="<?php echo base_url(); ?>" />

  	<!-- Mobile viewport optimized -->
  	<meta name="viewport" content="width=device-width,initial-scale=1">

  	<!-- CSS. No need to specify the media attribute unless specifically targeting a media type, leaving blank implies media=all -->
	<?php echo css('style.css'); ?>
  	<!-- End CSS-->

	<!-- Googlelicious -->
	<link href='http://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'>

	<!-- Load up some favicons -->
  	<link rel="shortcut icon" href="favicon.ico">
  	<link rel="apple-touch-icon" href="apple-touch-icon.png">
  	<link rel="apple-touch-icon" href="apple-touch-icon-precomposed.png">
  	<link rel="apple-touch-icon" href="apple-touch-icon-57x57-precomposed.png">
  	<link rel="apple-touch-icon" href="apple-touch-icon-72x72-precomposed.png">
  	<link rel="apple-touch-icon" href="apple-touch-icon-114x114-precomposed.png">

	<!-- Grab Google CDN's jQuery, with a protocol relative URL -->
  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>

	<!-- fall back to local if offline -->
  	<script>window.jQuery || document.write('<script src="<?php echo js_path('jquery/jquery.min.js'); ?>">\x3C/script>')</script>
	
	<!-- metadata needs to load before some stuff -->
	<?php file_partial('metadata'); ?>

</head>

<body>

	<div id="container">
		
		<section id="content">	

			<?php file_partial('header'); ?>
			
			<div id="content-body">
				<?php file_partial('notices'); ?>
				<?php echo $template['body']; ?>
			</div>

		</section>
	
	</div>
	
	<footer>
		<div class="wrapper">
			<p>Copyright &copy; 2010 PyroCMS &nbsp; -- &nbsp; Version <?php echo CMS_VERSION; ?> &nbsp; -- &nbsp; Rendered in {elapsed_time} sec. using {memory_usage}.</p>
		
			<ul id="lang">
				<form action="<?php echo current_url(); ?>" id="change_language" method="get">
					<select class="chzn" name="lang" onchange="this.form.submit();">				
						<?php foreach($this->config->item('supported_languages') as $key => $lang): ?>
		    				<option value="<?php echo $key; ?>" <?php echo CURRENT_LANGUAGE == $key ? 'selected="selected"' : ''; ?>>
								<?php echo $lang['name']; ?>
							</option>
        				<?php endforeach; ?>
	    			</select>
				</form>
			</ul>
		</div>
	</footer>

  	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6. chromium.org/developers/how-tos/chrome-frame-getting-started -->
  	<!--[if lt IE 7 ]>
    	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  	<![endif]-->

</body>
</html>