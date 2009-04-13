<?php
/**
 * SPAW Editor v.2 Output class
 *
 * Controls output of shared code to the client, prevents duplicates, etc. 
 * @package spaw2
 * @subpackage Output  
 * @author Alan Mendelevich <alan@solmetra.lt> 
 * @copyright UAB Solmetra
 */
 
/**
 * Controls output of shared code to the client, prevents duplicates, etc.
 * @package spaw2
 * @subpackage Output
 */   
class SpawOutput
{
  /**
   * Workaround for "static" class variable under php4
   * @access private
   */      
  function &buf()
  {
    static $buf;
    
    return $buf;
  }
  
  /**
   * Adds code to output buffer
   * @param string $name name of the code block
   * @param string $code code for output
   * @static   
   */
  function add($name, $code)
  {
    $buf = &SpawOutput::buf();
    $buf[$name] = $code;
  }
  
  /**
   * Returns content of the output
   * @returns string
   * @static   
   */
  function get()
  {
    $buf = &SpawOutput::buf();
    $str_buf = '';
    foreach($buf as $code)
    {
      $str_buf .= $code . "\r\n"; 
    }
    return $str_buf;
  }  
  
  /**
   * Outputs content of the buffer
   * @static       
   */       
  function show()
  {
    echo SpawOutput::get();
  }           
}

?>
