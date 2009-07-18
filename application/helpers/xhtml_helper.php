<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/*****
  * The xHTML helper returns xHTML 1.0 valid code
  * @author		Michael Wales
  * @email		webmaster@michaelwales.com
  * @filename	xhtml_helper.php
  * @title		xHTML Helper
  * @url		http://www.michaelwales.com/
  * @version	1.0
  *****/

  

	/***
	Returns an xHTML DOCTYPE tag
	  * @param		$language string		The language to use (html4, xhtml1, xhtml11)
	  * @param		$dtd string			The DTD to use (strict, loose, frameset, transitional)
	  * @return		string
	***/
	function xhtml_doctype($language = 'xhtml1', $dtd = 'strict') {
		$html4_dtd = array('strict', 'loose', 'frameset');
		$xhtml1_dtd = array('strict', 'transitional', 'frameset');
		$xhtml11_dtd = array('xhtml11');
		$error = '';
		$doctype = '';
		
		if ($language == 'html4') {
			if (in_array($dtd, $html4_dtd)) {
				$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"' . "\n\t" . '"http://www.w3.org/TR/html4/DTD/' . $dtd . '.dtd">';
			} else {
				$error = '<!-- xHTML Helper: Invalid DTD selection for this language, defaulting to HTML4 STRICT //-->';
				$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 STRICT//EN"' . "\n\t" . '"http://www.w3.org/TR/html4/DTD/strict.dtd">';
			}
		} elseif ($language == 'xhtml1') {
			if (in_array($dtd, $xhtml1_dtd)) {
				$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 ' . ucwords($dtd) . '//EN"' . "\n\t" . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-' . $dtd . '.dtd">';
			} else {
				$error = '<!-- xHTML Helper: Invalid DTD selection for this language, defaulting to xHTML1 STRICT //-->';
				$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 4.0 STRICT//EN"' . "\n\t" . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
			}
		} elseif ($language == 'xhtml11') {
			if (in_array($dtd, $xhtml11_dtd)) {
				$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"' . "\n\t" . '"http://www.w3.org/TR/xhtml11/DTD/' . $dtd . '.dtd">';
			} else {
				$error = '<!-- xHTML Helper: Invalid DTD selection for this language, defaulting to xHTML11 //-->';
				$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"' . "\n\t" . '"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
			}
		} else {
			$error = '<!-- xHTML Helper: Invalid language selection, defaulting to xHTML1 STRICT //-->';
			$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN"' . "\n\t" . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		}
		
		if ($error != '') {
			return $doctype . "\n" . $error . "\n";
		} else {
			return $doctype . "\n";
		}
	}
	
	/***
	Returns an xHTML HTML tag with xmlns parameter
	  * @param		$xmlns string		URL for namespace file
	  * @return		string
	***/
	function xhtml_html($xmlns = 'http://www.w3.org/1999/xhtml') {
		return '<html xmlns="' . $xmlns . '">' . "\n";
	}
	
	/***
	Returns an xHTML META tag for the Content-Type Character encoding
	  * @param		$charset string		The charset you want to sue
	  * @return		string
	***/
	function xhtml_contentType($charset = 'utf-8') {
		return '<meta http-equiv="Content-Type" content="text/html;charset=' . $charset . '" />' . "\n";
	}
?>