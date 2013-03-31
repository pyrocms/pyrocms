	<style type="text/css">
#exception_error {
	background: #ddd;
	font-size: 1em;
	font-family:sans-serif;
	text-align: left;
	color: #333333;
}
#exception_error h1,
#exception_error h2 {
	margin: 0;
	padding: 1em;
	font-size: 1em;
	font-weight: normal;
	background: #911911;
	color: #FFFFFF;
}
#exception_error h1 a,
#exception_error h2 a {
	color: #FFFFFF;
}
#exception_error h2 {
	background: #666666;
}
#exception_error h3 {
	margin: 0;
	padding: 0.4em 0 0;
	font-size: 1em;
	font-weight: normal;
}
#exception_error p {
	margin: 0;
	padding: .4em;
}
#exception_error a {
	color: #1b323b;
}
</style>

<div id="exception_error">
	<h1><span class="type"><?php echo $heading ?> [ <?php echo $status_code ?> ]</span></h1>
	<div class="content">
		<p><?php echo $message ?></p>
	</div>
</div>
