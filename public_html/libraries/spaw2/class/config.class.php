<?php
/**
 * SPAW Editor v.2 Config classes
 * 
 * Configuration related classes
 *   
 * @package spaw2
 * @subpackage Configuration  
 * @author Alan Mendelevich <alan@solmetra.lt> 
 * @copyright UAB Solmetra   
 */ 

/**
 * Specifies that value for the config item is not transfered to external parts of spaw
 */    
define("SPAW_CFG_TRANSFER_NONE", 0);
/**
 * Specifies that value for the config item is transfered via JavaScript variables
 */ 
define("SPAW_CFG_TRANSFER_JS", 1);
/**
 * Specifies that value for the config item is appended to request url
 */ 
define("SPAW_CFG_TRANSFER_REQUEST", 2);
/**
 * Specifies that value for the config item is stored on the server
 */ 
define("SPAW_CFG_TRANSFER_SECURE", 4);

/**
 * Configuration item class
 * 
 * Class defines single configuration item
 * @package spaw2
 * @subpackage Configuration    
 */ 
class SpawConfigItem
{
  /**
   * Sets config item values
   * @param string $name Config item's name
   * @param mixed $value Config item's value
   * @param integer $tranfer_type The way item should be transfered to other parts of the editor (one of SPAW_CFG_TRANSFER_* constants)
   * @return SpawConfigItem            
   */           
  function SpawConfigItem($name, $value, $transfer_type)
  {
    $this->name = $name;
    $this->value = $value;
    $this->transfer_type = $transfer_type;
  }
  /**
   * item name
   * @var string   
   */   
  var $name;
  /**
   * item value
   * @var mixed   
   */   
  var $value;
  /**
   * the way item is transferred to dialogs, etc. 
   * Holds information on the prefered method to transfer this value to external
   * of the editor like dialogs. Should be set to one (or several combined with OR)
   * of SPAW_CFG_TRANFER_* constants.
   * @var integer   
   */    
  var $transfer_type;
}

/**
 * Configuration class
 * 
 * Holds global (when accessed through class) SPAW configuration and 
 * instance configuration when insantiated
 * @package spaw2
 * @subpackage Configuration     
 */ 
class SpawConfig
{
  /**
   * array for instance config settings
   * @access private
   */      
  var $config;

  /**
   * Copies global SPAW configuration to instance
   */     
  function SpawConfig()
  {
    // copy static config to this instance
    $this->config = SpawConfig::configVar();
  }

  /**
   * Workaround for "static" class variable under php4
   * @access private
   */      
  function &configVar()
  {
    static $config;
    
    return $config;
  }
 
  /**
   * Sets global config item
   * @param string $name Config item's name
   * @param mixed $value Config item's value
   * @param integer $transfer_type Transfer type for the value (One or several of SPAW_CFG_TRANSFER_* constants). Default value - SPAW_CFG_TRANSFER_NONE
   * @see SPAW_CFG_TRANSFER_NONE, SPAW_CFG_TRANSFER_JS, SPAW_CFG_TRANSFER_REQUEST, SPAW_CFG_TRANSFER_SECURE
   * @static      
   */   
  function setStaticConfigItem($name, $value, $transfer_type=SPAW_CFG_TRANSFER_NONE)
  {
    $cfg = &SpawConfig::configVar();
    $cfg[$name] = new SpawConfigItem($name, $value, $transfer_type);
  }
  
  /**
   * Sets instance config item
   * @param string $name Config item's name
   * @param mixed $value Config item's value
   * @param integer $transfer_type Transfer type for the value (One or several of SPAW_CFG_TRANSFER_* constants). Default value - SPAW_CFG_TRANSFER_NONE
   * @see SPAW_CFG_TRANSFER_NONE, SPAW_CFG_TRANSFER_JS, SPAW_CFG_TRANSFER_REQUEST, SPAW_CFG_TRANSFER_SECURE   
   */   
  function setConfigItem($name, $value, $transfer_type=SPAW_CFG_TRANSFER_NONE)
  {
    $this->config[$name] = new SpawConfigItem($name, $value, $transfer_type);
  }
  
  /**
   * Gets global config item 
   * @param string $name Config item name
   * @returns SpawConfigItem      
   * @static      
   */   
  function getStaticConfigItem($name)
  {
    $cfg = &SpawConfig::configVar();
    if (isset($cfg[$name]))
      return $cfg[$name];
    else
      return NULL;
  }

  /**
   * Gets instance config item
   * @param string $name Config item name
   * @returns SpawConfigItem      
   */   
  function getConfigItem($name)
  {
    $cfg = $this->config;
    if (isset($cfg[$name]))
      return $cfg[$name];
    else
      return NULL;
  }

  /**
   * Sets global config item value
   * @param string $name Config item name
   * @param mixed $value Config item value
   * @static      
   */         
  function setStaticConfigValue($name, $value)
  {
    $cfg_item = SpawConfig::getStaticConfigItem($name);
    if ($cfg_item)
    {
      $cfg_item->value = $value;
      SpawConfig::setStaticConfigItem($cfg_item->name, $cfg_item->value, $cfg_item->transfer_type);
    }
  }

  /**
   * Sets global value for the element of config item provided item's value is an array
   * @param string $name Config item name
   * @param mixed $index Array index
   * @param mixed $value Element value
   */
  function setStaticConfigValueElement($name, $index, $value)
  {
    $cfg_item = SpawConfig::getStaticConfigItem($name);
    if ($cfg_item && is_array($cfg_item->value))
    {
      $cfg_item->value[$index] = $value;
      SpawConfig::setStaticConfigItem($cfg_item->name, $cfg_item->value, $cfg_item->transfer_type);
    }
  }              
  
  /**
   * Sets instance config item value
   * @param string $name Config item name
   * @param mixed $value Config item value
   */         
  function setConfigValue($name, $value)
  {
    $cfg_item = $this->getConfigItem($name);
    
    if ($cfg_item)
    {
      $cfg_item->value = $value;
      $this->setConfigItem($cfg_item->name, $cfg_item->value, $cfg_item->transfer_type);
    }
  }

  /**
   * Sets instance value for the element of config item provided item's value is an array
   * @param string $name Config item name
   * @param mixed $index Array index
   * @param mixed $value Element value
   */
  function setConfigValueElement($name, $index, $value)
  {
    $cfg_item = $this->getConfigItem($name);
    if ($cfg_item && is_array($cfg_item->value))
    {
      $cfg_item->value[$index] = $value;
      $this->setConfigItem($cfg_item->name, $cfg_item->value, $cfg_item->transfer_type);
    }
  }              
  
  /**
   * Gets global config item value
   * @param string $name Config item name
   * @returns mixed Config item value
   * @static      
   */         
  function getStaticConfigValue($name)
  {
    $cfg_item = SpawConfig::getStaticConfigItem($name);

    if ($cfg_item)
      return $cfg_item->value;
    else
      return NULL;
  }

  /**
   * Gets global value for the element of config item provided item's value is an array
   * @param string $name Config item name
   * @param mixed $index Array index
   * @returns mixed Element value
   */
  function getStaticConfigValueElement($name, $index)
  {
    $cfg_item = SpawConfig::getStaticConfigItem($name);
    if ($cfg_item && is_array($cfg_item->value) && !empty($cfg_item->value[$index]))
      return $cfg_item->value[$index];
    else
      return NULL;
  }              


  /**
   * Gets instance config item value
   * @param string $name Config item name
   * @returns mixed Config item value
   */         
  function getConfigValue($name)
  {
    $cfg_item = $this->getConfigItem($name);

    if ($cfg_item)
      return $cfg_item->value;
    else
      return NULL;
  }

  /**
   * Gets instance value for the element of config item provided item's value is an array
   * @param string $name Config item name
   * @param mixed $index Array index
   * @returns mixed Element value
   */
  function getConfigValueElement($name, $index)
  {
    $cfg_item = $this->getConfigItem($name);
    if ($cfg_item && is_array($cfg_item->value) && !empty($cfg_item->value[$index]))
      return $cfg_item->value[$index];
    else
      return NULL;
  }              
  
  /**
   * Stores "secure" config items in session and returns md5 of serialized config variables
   * @returns string
   */
  function storeSecureConfig()
  {
    $strcfg = '';
    $cfg = $this->config;
    $sec_cfg = array();
    $result = '';
    $stored_cfg = SpawVars::getSessionVar("spaw_configs");
    
    foreach($cfg as $key => $cfg_item)
    {
      if ($cfg_item->transfer_type & SPAW_CFG_TRANSFER_SECURE)
      {
        $strcfg .= $key . serialize($cfg_item);
        $sec_cfg[$key] = $cfg_item;
      } 
    }
    if ($strcfg != '')
    {
      $result = md5($strcfg);
      $stored_cfg[$result] = $sec_cfg;
      SpawVars::setSessionVar("spaw_configs", $stored_cfg);
    }
    return $result;
  }
  
  /**
   * Restores "secure" config items from session
   * @params string $scid Config id
   */                
  function restoreSecureConfig($scid)
  {
    $sec_cfg = SpawVars::getSessionVar("spaw_configs");
    if ($sec_cfg != null && $sec_cfg != '' && is_array($sec_cfg) && isset($sec_cfg[$scid]) && is_array($sec_cfg[$scid]))
    {
      foreach($sec_cfg[$scid] as $key => $cfg_item)
        $this->setConfigItem($cfg_item->name, $cfg_item->value, $cfg_item->transfer_type);
    }
  }
}
?>
