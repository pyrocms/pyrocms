<?php
/**
 * SPAW Editor v.2 Language classes
 * 
 * Language related classes
 *   
 * @package spaw2
 * @subpackage Language  
 * @author Alan Mendelevich <alan@solmetra.lt> 
 * @copyright UAB Solmetra
 */ 


require_once(str_replace('\\\\','/',dirname(__FILE__)).'/config.class.php');

/**
 * Language class
 * 
 * Stores and retrieves language specific strings and other information  
 * @package spaw2
 * @subpackage Language  
 */ 
class SpawLang
{
  /**
   * Holds language abbreviation (like "en", "lt", etc.)
   * @access private
   * @var string
   */           
  var $lang;
  /**
   * Sets current language (abbreviation like "en", "lt", etc.)
   * @param string $value Language abbreviation
   */           
  function setLang($value)
  {
    $this->lang = $value;
  }
  /**
   * Gets current language (abbreviation like "en", "lt", etc.)
   * @returns string Language abbreviation
   */           
  function getLang()
  {
    return $this->lang;
  }

  /**
   * Holds name of current module/plugin (used to determine location of language file)
   * @access private
   * @var string
   */           
  var $module;
  /**
   * Sets name of current module/plugin (used to determine location of language file)
   * @param string $value Module name
   */      
  function setModule($value)
  {
    $this->module = $value;
  }
  /**
   * Returns the name of current module/plugin (used to determine location of language file)
   * @returns string Module name
   */      
  function getModule()
  {
    return $this->module;
  }
  
  /**
   * Holds name of current language block (section in language file)
   * @access private
   * @var string
   */           
  var $block;
  /**
   * Sets name of current language block (section in language file)
   * @param string $value Block name
   */           
  function setBlock($value)
  {
    $this->block = $value;
  }
  /**
   * Returns the name of current language block (section in language file)
   * @returns string Block name
   */           
  function getBlock()
  {
    return $this->block;
  }
  
  /**
   * Holds the charset for the current language file
   * @access private
   * @var string
   */           
  var $charset;
  /**
   * Returns the charset for the current language file
   * @returns string Charset name
   */           
  function getCharset()
  {
    return $this->charset;
  }

  /**
   * Holds desired output charset
   * @access private
   * @var string
   */
  var $output_charset;
  /**
   * Sets output charset (desired charset for output strings) (USE_ICONV config item should be set to true)
   * @param string $value Desired output charset
   */
  function setOutputCharset($value)
  {
    $this->output_charset = $value;
  }
  /**
   * Returns output charset (desired charset for output strings) (USE_ICONV config item should be set to true)
   * @returns string
   */
  function getOutputCharset()
  {
    return $this->output_charset;
  }                 

  /**
   * Holds text direction (ltr or rtl) for current language file
   * @access private
   * @var string
   */           
  var $dir = 'ltr';
  /**
   * Returns text direction (ltr or rtl) for current language file
   * @returns string Text direction string
   */           
  function getDir()
  {
    return $this->dir;
  }
  
  /**
   * Holds language data
   * @access private
   * @var array
   */           
  var $lang_data;

  /**
   * Holds English language data
   * @access private
   * @var array
   */           
  var $en_lang_data;

  /**
   * Constructs SPAW_Lang object
   * @param string $lang Language abbreviation (like "en", "lt", etc.)
   */           
  function SpawLang($lang = '')
  {
    if ($lang == '')
    {
      // default lang
      $this->lang = SpawConfig::getStaticConfigValue("default_lang");
    }
    else
    {
      $this->lang = $lang;
    }
    // load core data
    $this->loadData('core');
  }

  /**
   * Loads language data into {@link $lang_data} array
   * @param string $module Module name
   */        
  function loadData($module)
  {
    $spaw_root = SpawConfig::getStaticConfigValue("SPAW_ROOT");

    if (file_exists($spaw_root.'plugins/'.$module.'/lib/lang/'.$this->lang.'.lang.inc.php'))
    {
      // language data for selected language
      $filename = $spaw_root.'plugins/'.$module.'/lib/lang/'.$this->lang.'.lang.inc.php';
    }
    else
    {
      // english language file
      $filename = $spaw_root.'plugins/'.$module.'/lib/lang/en.lang.inc.php';
    }

    @include($filename);
    if ($module == 'core' || empty($this->charset))
    {
      $this->charset = $spaw_lang_charset;
      if (!empty($spaw_lang_direction)) $this->dir = $spaw_lang_direction;
    }
    $this->lang_data[$module] = $spaw_lang_data;
    if ($this->lang != 'en')
    {
      // additionally load English language file for backup purposes
      $filename = $spaw_root.'plugins/'.$module.'/lib/lang/en.lang.inc.php';
      @include($filename);
      $this->en_lang_data[$module] = $spaw_lang_data;
    }
    else
    {
      $this->en_lang_data[$module] = $spaw_lang_data;
    }
  }

  /**
   * Returns message string
   * @param string $message Message id
   * @param string $block Block id
   * @param string $module Module name
   * @returns string
   */                 
  function getMessage($message, $block='', $module='')
  {
    $_module = ($module == '')?$this->module:$module;
    $_block = ($block == '')?$this->block:$block;
    if (empty($this->lang_data[$_module]))
    {
      // load module data
      $this->loadData($_module);
    }
    $msg = '';
    if (!empty($this->lang_data[$_module][$_block][$message]))
    {
      $msg = $this->lang_data[$_module][$_block][$message];
    }
    else if (!empty($this->en_lang_data[$_module][$_block][$message]))
    {
      $msg = $this->en_lang_data[$_module][$_block][$message];
    }
    if ($msg != '')
    {
      if (SpawConfig::getStaticConfigValue("USE_ICONV") && isset($this->output_charset) 
          && $this->charset != $this->output_charset)
      {
        // convert charsets (ignore illegal characters)
        $msg = iconv($this->charset, $this->output_charset.'//IGNORE', $msg);
      }
      // return message
      return $msg;
    }
    else
    {
      // return empty string
      return '';
    }
  }
  
  /**
   * Shortcut for {@link getMessage()}
   */     
  function m($message, $block='', $module='')
  {
    return $this->getMessage($message, $block, $module);
  }
} // SPAW_Lang

?>
