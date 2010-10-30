<?php
header('Content-type: text/css');
/* TODO: Implement Caching headers */

/* We could make this into an "asset" module that also does JS */

// Send the output to the css compression function
ob_start("compress_css");

/**
 * Compress
 * 
 * Compresses CSS
 * 
 * @param	string	$buffer
 * @return	string
 */
function compress_css($buffer)
{
	// Remove the comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

	// Remove tabs, spaces, newlines
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '	 ', '	 ', '	 '), '', $buffer);
	return $buffer;
}

/* Include and put CSS below here */

include 'reset.css';
include 'layout.css';

include '../boxes.css';
include '../common.css';
include '../links.css';
include '../lists.css';

echo <<<CSS
.default-input-text {
	color:#AAAAAA;
}

.CodeMirror-wrapping {
	border: 1px solid #bbb;
}

.CodeMirror-line-numbers {
	width: 2.2em;
	background-color: #eee;
	color:#AAAAAA;
	font-family:monospace;
	font-size:10pt;
	text-align:right;
 }
 
.CodeMirror-line-numbers div {
	margin:0;
}

.ui-draggable, .ui-sortable {
	cursor:move;
}
CSS;

ob_end_flush();
