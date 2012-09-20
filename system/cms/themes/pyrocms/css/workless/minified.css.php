<?php 
header('Content-type: text/css');
ob_start("compress");

	function compress($buffer) {
		/* remove comments */
    	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    		
    	/* remove tabs, spaces, newlines, etc. */
    	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    		
    	return $buffer;
	}

  	/* css files for compression */
  	include('plugins.css');
  	include('workless.css');
  	include('typography.css');
  	include('forms.css');
  	include('tables.css');
  	include('buttons.css');
  	include('alerts.css');
  	include('tabs.css');
  	include('pagination.css');
  	include('breadcrumbs.css');
  	include('icons.css');
  	include('helpers.css');
    include('scaffolding.css');
  	include('print.css');
  	include('application.css');

ob_end_flush();
?>
