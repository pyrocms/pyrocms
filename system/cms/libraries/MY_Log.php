<?php
/**
 * MY_Log (v1.0)
 *
 * Provides a feature for user to store the logs in different files
 *
 * @author      Kefeng Deng
 */
class MY_Log extends CI_Log
{

    /**
     * Predefined logging levels
     *
     * @var array
     */
    protected $_levels		= array('ERROR' => 1, 'WARN' => 2, 'INFO' => 3, 'DEBUG' => 4, 'ALL' => 5);


    /**
     * Predefined logging path date
     *
     * @var String
     */
    protected $_log_path_date = '';

    /**
     * Predefined logging path array
     *
     * @var array
     */

    protected $_log_path_array = array('Y', 'Y/m', 'Y/m/d');

    /**
     * Predefined the postfix of log file
     *
     * @var String
     */

    protected $_file_postfix = '';

    /**
     * Initialize Logging class
     *
     * @return	void
     */
    public function __construct()
    {
        $config =& get_config();

        $this->_log_path = ($config['log_path'] !== '') ? $config['log_path'] : APPPATH.'logs/';

        if ($config['log_path_date'] !== '' && in_array($config['log_path_date'], $this->_log_path_array))
        {
            $this->_log_path_date = $config['log_path_date'];
            $this->_log_path .= date($config['log_path_date']).'/';
            is_dir($this->_log_path) OR mkdir($this->_log_path, DIR_WRITE_MODE, true);
        }

        if ( ! is_dir($this->_log_path) OR ! is_really_writable($this->_log_path))
        {
            $this->_enabled = FALSE;
        }

        if (is_numeric($config['log_threshold']))
        {
            $this->_threshold = (int) $config['log_threshold'];
        }
        elseif (is_array($config['log_threshold']))
        {
            $this->_threshold = $this->_threshold_max;
            $this->_threshold_array = in_array(0, $config['log_threshold'])?array():in_array(5, $config['log_threshold'])?array_values($this->_levels):$config['log_threshold'];
        }

        if ($config['log_date_format'] !== '')
        {
            $this->_date_fmt = $config['log_date_format'];
        }

        if ($config['log_path_date'] !== '')
        {
            $this->_filepath_postfix = date(str_replace(str_replace('/','-', $this->_log_path_date), '', 'Y-m-d'));
        }
        else
        {
            $this->_filepath_postfix = '-'.date('Y-m-d');
        }

    }

    /**
     * Write Log File
     *
     * Generally this function will be called using the global log_message() function
     *
     * @param	string	the error level
     * @param	string	the error message
     * @param	bool	whether the error is a native PHP error
     * @return	bool
     */
    public function write_log($level = 'error', $msg, $php_error = FALSE)
    {
        if ($this->_enabled === FALSE)
        {
            return FALSE;
        }

        $level = strtoupper($level);

        if (( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
            && ! in_array($this->_levels[$level], $this->_threshold_array))
        {
            return FALSE;
        }

        $filepath = $this->_log_path;

        if ($php_error === FALSE || $php_error === TRUE)
        {
            $filepath .= 'log';
        }
        else
        {
            $filepath .= $php_error;
        }

        $filepath .= $this->_filepath_postfix.'.php';

        $message  = '';

        if ( ! file_exists($filepath))
        {
            $newfile = TRUE;
            $message .= '<'."?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
        }

        if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
        {
            return FALSE;
        }

        $message .= $level.' '.($level === 'INFO' ? ' -' : '-').' '.date($this->_date_fmt).' --> '.$msg."\n";

        flock($fp, LOCK_EX);
        fwrite($fp, $message);
        flock($fp, LOCK_UN);
        fclose($fp);

        if (isset($newfile) && $newfile === TRUE)
        {
            @chmod($filepath, FILE_WRITE_MODE);
        }

        return TRUE;
    }

}