<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		MizuCMS
 * @subpackage 		WYSIWYG
 * @author			Phil Sturgeon
 *
 * Manages document selection and insertion for WYSIWYG editors
 */
class WYSIWYG extends WYSIWYG_Controller
{
	function __construct()
	{
		parent::WYSIWYG_Controller();

		$this->load->model('file_m');
	}

	function index()
	{
		$this->template->build('wysiwyg/index', $this->data);
	}
}