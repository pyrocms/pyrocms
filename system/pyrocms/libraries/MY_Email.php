<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY_Email - Allows for email config settings to be stored in the db.
 * 
 * @author      Stephen Cozart - PyroCMS dev team
 * @package 	PyroCMS
 * @subpackage  library
 * @category	email   
 */
class MY_Email extends CI_Email {
    
    protected $ci;
    
    /**
     * Constructor method
     *
     * @access public
     * @return void
     */
    function __construct()
    {
        parent::__construct();
        
        $this->ci =& get_instance();
        
        //set mail protocol
        $config['protocol'] = $this->ci->settings->mail_protocol;
        
        //set a few config items (duh)
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['crlf'] = '\r\n';
        $config['newline'] = '\r\n';
        
        //sendmail options
        if($this->ci->settings->mail_protocol == 'sendmail')
        {
                if($this->ci->settings->mail_sendmail_path == '')
                {
                        //set a default
                        $config['mailpath'] = '/usr/sbin/sendmail';
                }
                else
                {
                        $config['mailpath'] = $this->ci->settings->mail_sendmail_path;
                }
        }
        
        //smtp options
        if($this->ci->settings->mail_protocol == 'smtp')
        {
                $config['smtp_host'] = $this->ci->settings->mail_smtp_host;
                $config['smtp_user'] = $this->ci->settings->mail_smtp_user;
                $config['smtp_pass'] = $this->ci->settings->mail_smtp_pass;
                $config['smtp_port'] = $this->ci->settings->mail_smtp_port;
        }
        
        $this->initialize($config);
    }    
}
/* End of file MY_Email.php */