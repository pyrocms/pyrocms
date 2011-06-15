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
    
    /**
     * Constructor method
     *
     * @access public
     * @return void
     */
    function __construct($config = array())
    {
        parent::__construct($config);
        
        //set mail protocol
        $config['protocol'] = Settings::get('mail_protocol');
        
        //set a few config items (duh)
        $config['mailtype']	= 'html';
        $config['charset']	= 'utf-8';
        $config['crlf']		= '\r\n';
        $config['newline']	= '\r\n';
        
        //sendmail options
        if (Settings::get('mail_protocol') == 'sendmail')
        {
                if(Settings::get('mail_sendmail_path') == '')
                {
                        //set a default
                        $config['mailpath'] = '/usr/sbin/sendmail';
                }
                else
                {
                        $config['mailpath'] = Settings::get('mail_sendmail_path');
                }
        }
        
        //smtp options
        if (Settings::get('mail_protocol') == 'smtp')
        {
                $config['smtp_host'] = Settings::get('mail_smtp_host');
                $config['smtp_user'] = Settings::get('mail_smtp_user');
                $config['smtp_pass'] = Settings::get('mail_smtp_pass');
                $config['smtp_port'] = Settings::get('mail_smtp_port');
        }
        
        $this->initialize($config);
    }    
}
/* End of file MY_Email.php */