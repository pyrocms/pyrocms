<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* CodeIgniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package        CodeIgniter
* @author        ExpressionEngine Dev Team
* @copyright    Copyright (c) 2008, EllisLab, Inc.
* @license        http://codeigniter.com/user_guide/license.html
* @link        http://codeigniter.com
* @since        Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* DB Debug Class
*
* Helps you debug your ActiveRecord queries over mail, log or screen
*
* @package        CodeIgniter
* @subpackage    Libraries
* @category    Database
* @author        Phil Sturgeon < email@philsturgeon.co.uk >
* @link        
*/

class DB_debug extends CI_DB_active_record {
    
    var $_email; // Used to send emails from the server
    var $_mode;
    var $_run_query = FALSE;
    
    function mode($mode, $email = NULL)
    {
        $this->_mode = $mode;
        $this->_email = $email;
        
        return $this;
    }
    
    function run()
    {
        $this->_run_query = TRUE;
        
        return $this;
    }
    
    function query($sql)
    {
        log_message('debug', 'DB Deug class produced: '.htmlentities($sql) );
        
        switch($this->_mode)
        {
            case 'email':
                $this->load->library('email');

                $this->email->to($this->_email);
                
                $this->email->subject('SQL Debug: '.time());
                $this->email->message('SQL query: '.$sql);
                
                $this->email->send();
            break;
            
            case 'echo':
            	echo $sql;
            break;
            
            case 'exit':
            	exit($sql);
            break;
        }
        
    }
}

/* End of file DB_active_rec.php */
/* Location: ./system/application/libraries/DB_debug.php */ 