<?php
/**
 * SPAW Editor v.2 Editor classes
 *
 * Main editor classes 
 * @package spaw2
 * @subpackage Editor  
 * @author Alan Mendelevich <alan@solmetra.lt> 
 * @copyright UAB Solmetra
 */ 

require_once(str_replace('\\\\','/',dirname(__FILE__)).'/config.class.php');
require_once(str_replace('\\\\','/',dirname(__FILE__)).'/toolbar.class.php');
require_once(str_replace('\\\\','/',dirname(__FILE__)).'/theme.class.php');
require_once(str_replace('\\\\','/',dirname(__FILE__)).'/lang.class.php');

/**
 * Represetns editor page
 * @package spaw2
 * @subpackage Editor
 */
class SpawEditorPage
{
  /**
   * Page name
   * @var string
   */
  var $name;
  
  /**
   * Name of the page input (textarea)
   * @var string
   */
  var $inputName;
          
  /**
   * Page caption
   * @var string
   */
  var $caption;
  
  /**
   * Page direction
   * @var string
   */
  var $direction;        
  
  /**
   * Page content
   * @var string
   */
  var $value;
  
  /**
   * Constructor
   * @param string $name Name
   * @param string $caption Caption
   * @param string $value Initial content
   */
  function SpawEditorPage($name, $caption, $value = '', $direction = 'ltr')
  {
    // workaround for names with [ and ]
    $_page_count = SpawConfig::getStaticConfigItem('_page_count');
    if ($_page_count != null)
    {
      SpawConfig::setStaticConfigItem('_page_count', $_page_count->value + 1);
    }
    else
    {
      SpawConfig::setStaticConfigItem('_page_count', 1);
    }
    $_pn = SpawConfig::getStaticConfigValue('_page_count'); 
    
    $ctrl_id = str_replace(']','_', str_replace('[', '_', $name));
    if ($ctrl_id != $name)
      $ctrl_id = $ctrl_id . '_' . $_pn;
    
    $this->name = $ctrl_id;
    $this->inputName = $name;
    $this->caption = $caption;
    $this->value = $value;
    $this->direction = $direction;
  }                                     
}   

/**
 * Represents the editor as a whole
 * @package spaw2
 * @subpackage Editor
 */   
class SpawEditor
{
  /**
   * Holds editor name
   * @var string
   */
  var $name;        


  /**
   * Workaround for "static" class variable under php4
   * @access private
   */      
  function &scriptSent()
  {
    static $script_sent;
    
    return $script_sent;
  }

  /**
   * Constructor
   * @param string $name Editor name
   */        
  function SpawEditor($name, $value='', $lang='', $toolbarset='', 
                      $theme='', $width='', $height='', $stylesheet='', $page_caption='')
  {
    $this->name = $name;

    // add first page    
    $page_caption = ($page_caption != '')?$page_caption:$name;
    $page = new SpawEditorPage($name, $page_caption, $value);
    if ($page->name != $this->name)
      $this->name = $page->name;
    $this->addPage($page);
    $this->setActivePage($page);
    
    if ($lang != '')
      $this->setLanguage($lang); 
//    if ($toolbarset != '')
//      $this->addToolbarSet($toolbarset);
    if ($theme != '')
      $this->setTheme($theme);
    if ($width != '')
      $this->setDimensions($width, null);
    if ($height != '')
      $this->setDimensions(null, $height);
    if ($stylesheet != '')
      $this->setStylesheet($stylesheet);
    
    // load static config
    $this->config = new SpawConfig();

    if ($toolbarset != '')
      $this->setConfigValue('default_toolbarset',$toolbarset);
  }
  
  /**
   * Stores instance config
   * @var SpawConfig
   */
  var $config;        
  
  /**
   * Stores instance width
   * @var string
   */
  var $width;        

  /**
   * Stores instance height
   * @var string
   */
  var $height;
  
  /**
   * Sets editor dimensions
   * @param string width
   * @param string height
   */
  function setDimensions($width, $height)
  {
    if ($width != null && $width != '')
      $this->width = $width;
    if ($height != null && $height != '')
      $this->height = $height;
  }                   
  
  /**
   * Stores toolbars used in this instance
   * @var array
   */        
  var $toolbars;
  
  /**
   * Adds toolbars to current instance (unlimited number of arguments could be passed)
   * 
   * Specify a comma separated list of toolbars that should be displayed (ie. "format","table",etc.).      
   * @param string $toolbar,... list of toolbar names
   */         
  function addToolbars($toolbar='')
  {
    $numargs = func_num_args();
    if ($numargs)
    {
      // add specified toolbars
      $args = func_get_args();
      for ($i=0; $i<$numargs; $i++)
      {
        $this->toolbars[$args[$i]] = SpawToolbar::getToolbar($args[$i]);
        $this->toolbars[$args[$i]]->editor = &$this;
      }
    }
  }

  /**
   * Adds toolbar set
   * @param string toolbar set name
   */
  function addToolbarSet($toolbarset)
  {
    $tset = SpawConfig::getStaticConfigValue("toolbarset_".$toolbarset);
    if (is_array($tset))
    {
      foreach($tset as $substitute => $toolbar)
      {
        $this->addToolbar($toolbar, $substitute);
      }
    }
  }        
  
  /**
   * Adds toolbar (substitutes other toolbar if $substiture is specified)
   * @param string $toolbar name of the toolbar to add
   * @param string $substitute place this toolbar in place of specified
   */           
  function addToolbar($toolbar, $substitute='')
  {
    $index = empty($substitute)?$toolbar:$substitute;

    $this->toolbars[$index] = SpawToolbar::getToolbar($toolbar);  
    $this->toolbars[$index]->editor = &$this;
  }
  
  /**
   * Theme/skin
   * @var SpawTheme
   */
  var $theme;
  
  /**
   * Sets theme/skin for the instance
   * @param string $theme Theme name
   */        
  function setTheme($theme)
  {
    $this->theme = SpawTheme::getTheme($theme);
  }
  
  /**
   * Language
   * @var SpawLang
   */
  var $lang;        
  
  /**
   * Sets editor language
   * @param string $lang abbreviation of the language code
   * @param string $out_charset output charset   
   */
  function setLanguage($lang='', $out_charset='')
  {
    $this->lang = new SpawLang($lang);
    if ($out_charset != null && $out_charset != '')
      $this->lang->setOutputCharset($out_charset);
  }         

  /**
   * Editing area stylesheet
   * @param string path to stylesheet file
   */        
  var $stylesheet;
  
  /**
   * Sets editing area stylesheet
   * @param string $filename path to stylesheet file
   */
  function setStylesheet($filename)
  {
    $this->stylesheet = $filename;
  }        

  /**
   * Pages collection
   * @var array
   */
  var $pages;
  
  /**
   * Adds page
   * @param SpawEditorPage page Page object
   */
  function addPage($page)
  {
    $this->pages[$page->name] = $page;
  }
  
  /**
   * Returns page
   * @param string $name Page name
   * @returns SpawEditorPage
   */
  function getPage($name)
  {
    if (!empty($this->pages[$name]))
      return $this->pages[$name];
    else
      return NULL;
  }
  
  /**
   * Holds currently active page
   * @var SpawEditorPage
   */
  var $active_page;
  
  /**
   * Sets active page
   * @param SpawEditorPage $page
   */
  function setActivePage($page)
  {
    $this->active_page = $page;
  }
  
  /**
   * Returns active page
   * @returns SpawEditorPage
   */
  function getActivePage()
  {
    return $this->active_page;
  }  
  
  /**
   * Floating toolbar mode flag
   * @var bool
   */
  var $floating_mode = false;
  
  /**
   * Sets floating toolbar mode on or off
   * @param bool $value Should floating mode be enabled
   */
  function setFloatingMode($controlled_by = '', $value = true)
  {
    $this->floating_mode = $value;
    if ($value)
      $this->setToolbarFrom($controlled_by);
  }                               
  
  /**
   * Returs true if floating toolbar mode is enabled
   * @returns bool
   */
  function getFloatingMode()
  {
    return $this->floating_mode;
  }   
  
  /**
   * Holds instance of another SpawEditor which controls floating toolbar used for this instance
   * 
   * If empty, this is the "main" instance for floating toolbar
   * @var SpawEditor
   */
  var $toolbar_from;
  
  /**
   * Sets variable holding instance of another SpawEditor which controls floating toolbar used for this instance
   * @param SpawEditor $controlled_by
   */
  function setToolbarFrom($controlled_by = '')
  {
    if ($controlled_by == '')
      $controlled_by = $this;
    $this->toolbar_from = $controlled_by;
  }
  
  /**
   * Returns instance of another SpawEditor which controls floating toolbar used for this instance
   * @returns SpawEditor
   */
  function getToolbarFrom()
  {
    if ($this->toolbar_from)
      return $this->toolbar_from;
    else
      return $this;
  }

  /**
   * Holds value whether mode strip should be displayed or not
   * @var bool
   */
  var $is_mode_strip_visible = true;
  /**
   * Sets value indicating that mode strip should be shown
   */
  function showModeStrip()
  {
    $this->is_mode_strip_visible = true;
  }             
  /**
   * Sets value indicating that mode strip shouldn't be shown
   */
  function hideModeStrip()
  {
    $this->is_mode_strip_visible = false;
  }
  /**
   * Returns value indicating whether mode strip should be shown or not
   * @returns bool
   */
  function isModeStripVisible()
  {
    return $this->is_mode_strip_visible;
  }                       

  /**
   * Holds value whether status bar should be displayed or not
   * @var bool
   */
  var $is_status_bar_visible = true;
  /**
   * Sets value indicating that status bar should be shown
   */
  function showStatusBar()
  {
    $this->is_status_bar_visible = true;
  }             
  /**
   * Sets value indicating that status bar shouldn't be shown
   */
  function hideStatusBar()
  {
    $this->is_status_bar_visible = false;
  }
  /**
   * Returns value indicating whether status bar should be shown or not
   * @returns bool
   */
  function isStatusBarVisible()
  {
    return $this->is_status_bar_visible;
  }                       

  /**
   * Holds value whether resizing grip should be displayed or not
   * @var bool
   */
  var $is_resizable = true;
  /**
   * Sets value indicating that resizing grip should be shown
   */
  function showResizingGrip()
  {
    $this->is_resizable = true;
  }             
  /**
   * Sets value indicating that resizing grip shouldn't be shown
   */
  function hideResizingGrip()
  {
    $this->is_resizable = false;
  }
  /**
   * Returns value indicating whether resizing grip should be shown or not
   * @returns bool
   */
  function isResizingGripVisible()
  {
    return $this->is_resizable;
  }                       
  
  /**
   * Holds value whether editor is in read-only mode
   * @var bool
   */
  var $is_read_only = false;
  
  /** 
   * Set's instance config item
   * @param bool $value Value of read-only state (true - read-only, false - editable)   
   */
  function setReadOnly($value=true)
  {
    $this->is_read_only = $value;
  }
  /**
   * Returns value indicating whether editor is in read-only mode
   * @returns bool
   */
  function isReadOnly()
  {
    return $this->is_read_only;
  }                       

  
  /** 
   * Set's instance config item
   * @param string $name Config item's name
   * @param mixed $value Config item's value
   * @param integer $transfer_type Transfer type for the value (One or several of SPAW_CFG_TRANSFER_* constants). Default value - SPAW_CFG_TRANSFER_NONE
   */
  function setConfigItem($name, $value, $transfer_type=SPAW_CFG_TRANSFER_NONE)
  {
    $this->config->setConfigItem($name, $value, $transfer_type);
  }

  /**
   * Gets instance config item
   * @param string $name Config item name
   * @returns SpawConfigItem      
   */   
  function getConfigItem($name)
  {
    return $this->config->getConfigItem($name);
  }   

  /**
   * Sets instance config item value
   * @param string $name Config item name
   * @param mixed $value Config item value
   */         
  function setConfigValue($name, $value)
  {
    $this->config->setConfigValue($name, $value);
  }

  /**
   * Sets instance value for the element of config item provided item's value is an array
   * @param string $name Config item name
   * @param mixed $index Array index
   * @param mixed $value Element value
   */
  function setConfigValueElement($name, $index, $value)
  {
    $this->config->setConfigValueElement($name, $index, $value);
  }              

  /**
   * Gets instance config item value
   * @param string $name Config item name
   * @returns mixed Config item value
   */         
  function getConfigValue($name)
  {
    return $this->config->getConfigValue($name);
  }
  
  /**
   * Gets instance value for the element of config item provided item's value is an array
   * @param string $name Config item name
   * @param mixed $index Array index
   * @returns mixed Element value
   */
  function getConfigValueElement($name, $index)
  {
    return $this->config->getConfigValueElement($name, $index);
  }              
  
  /**
   * Sets default property values if they were not explicitly specified
   */
  function setDefaults()
  {
    if ($this->theme == null)
      $this->setTheme($this->config->getConfigValue('default_theme'));
    if ($this->toolbars == null)
      $this->addToolbarSet($this->config->getConfigValue('default_toolbarset'));
    if ($this->stylesheet == null)
      $this->setStylesheet($this->config->getConfigValue('default_stylesheet'));
    if ($this->width == null)
      $this->setDimensions($this->config->getConfigValue('default_width'), null);
    if ($this->height == null)
      $this->setDimensions(null, $this->config->getConfigValue('default_height'));
    if ($this->lang == null)
      $this->setLanguage($this->config->getConfigValue('default_lang'), $this->config->getConfigValue('default_output_charset'));
  }     
  
  /**
   * Returns HTML and JavaScript code for the editor
   * @returns string
   */
  function getHtml()
  {
    $res = '';
    $this->setDefaults();
    if (SpawAgent::getAgent() != SPAW_AGENT_UNSUPPORTED)
    {
      // supported browser
      $head_res = '';
      $js_res = '';
      $html_res = '';
      $ssent = &SpawEditor::scriptSent();
      if (!$ssent)
      {
        $head_res .= '<script type="text/javascript" src="'.SpawConfig::getStaticConfigValue("SPAW_DIR").'js/spaw.js.php" charset="utf-8"></script>';
        $js_res .= 'SpawEngine.setSpawDir("'. SpawConfig::getStaticConfigValue("SPAW_DIR") . '"); SpawEngine.setPlatform("php");';
        $ssent = true;
      }
      $objname = $this->name.'_obj';
      
      // handle read-only state
      if ($this->isReadOnly())
      {
        $this->toolbars = array();
        $this->hideModeStrip();
      }
      
      $js_res .= 'var '.$objname.' = new SpawEditor("'.$this->name.'");';
      $js_res .= 'SpawEngine.registerEditor('.$objname.');';
      $js_res .= $objname.'.setTheme(SpawTheme'.$this->theme->name.');';
      $js_res .= $objname.'.setLang("'.$this->lang->lang.'");';
      $js_res .= $objname.'.setOutputCharset("'.$this->lang->getOutputCharset().'");';
      $js_res .= $objname.'.stylesheet = "'.$this->stylesheet.'";';
      $js_res .= $objname.'.scid = "'.$this->config->storeSecureConfig().'";';
      $js_res .= $objname.'.enabled = '.($this->isReadOnly()?"false":"true").';';
  
      // add javascript or request uri config items
      $reqstr = '';
      foreach($this->config->config as $cfg)
      {
        if (($cfg->transfer_type & SPAW_CFG_TRANSFER_JS) && is_scalar($cfg->value))
        {
          if (is_numeric($cfg->value))
            $js_res .= $objname.'.setConfigValue("'.$cfg->name.'", '.$cfg->value.');';
          else if (is_bool($cfg->value))
            $js_res .= $objname.'.setConfigValue("'.$cfg->name.'", '.($cfg->value?'true':'false').');';
          else // string
            $js_res .= $objname.'.setConfigValue("'.$cfg->name.'", "'.$cfg->value.'");';
        }
        if (($cfg->transfer_type & SPAW_CFG_TRANSFER_REQUEST) && is_scalar($cfg->value))
        {
          if (is_bool($cfg->value))
            $reqstr .= '&'.$cfg->name.'='.($cfg->value?'true':'false');
          else // string, number
            $reqstr .= '&'.$cfg->name.'='.$cfg->value;
        }
      }
      if ($reqstr != '')
      {
        $js_res .= $objname.'.setConfigValue("__request_uri", "'.$reqstr.'");';
      }
  
  
  
      $tpl = ''; // template
      $fedtpl = ''; // editor template in floating mode
      $other_present = false;
  
      $tbfrom = $this->getToolbarFrom();
      
      // parse template
      if (!$this->getFloatingMode())
      {
        // standard mode
        $tpl = $this->theme->getTemplate();
      }
      else
      {
        // floating mode
        $tpl = '<span id="'.$this->name.'_toolbox" ';
        $tpl .= ' style="z-index: 10000; position: absolute; cursor: move;"';
        $tpl .= ' onMouseDown="'.$objname.'.floatingMouseDown(event);"';
        $tpl .= ' >';
        $tpl .= $this->theme->getTemplateToolbar();
        $tpl .= '</span>';
        $tpl .= $this->theme->getTemplateFloating();
      }
      // if this is the main toolbar instance, add toolbars
      if ($tbfrom->name == $this->name && !$this->isReadOnly())
      {
        foreach($this->toolbars as $key => $tb)
        {
          if (strpos($tpl, '{SPAW TB='.strtoupper($key).'}'))
          {
            // toolbar placeholder found
            $tpl = preg_replace('/(\{SPAW TB='.strtoupper($key).'\})(.*)(\{SPAW TOOLBAR\})(.*)(\{\/SPAW TB\})/sU', '$2'.$tb->renderToolbar($this->name, $this->theme).'$4', $tpl);
          }
          else
          {
            // add to other toolbar placeholder
            $tpl = preg_replace('/(\{SPAW TB=_OTHER\})(.*)(\{SPAW TOOLBAR\})(.*)(\{\/SPAW TB\})/sU', '$1$2'.$tb->renderToolbar($this->name, $this->theme).'{SPAW TOOLBAR}$4$5', $tpl);
            $other_present = true;
          }
        }
      }
      elseif (($this->getFloatingMode() && $this->toolbar_from->name != $this->name) || $this->isReadOnly())
      {
        // editor template for floating mode slave
        $tpl = $this->theme->getTemplateFloating();
      }
      
      // replace all spaw dir references
      $tpl = str_replace("{SPAW DIR}", SpawConfig::getStaticConfigValue("SPAW_DIR"), $tpl);
      
      if ($this->getFloatingMode())
      {
        $js_res .= $objname.'.floating_mode = true;';
      }
      // register this editor as controlled by other editors toolbar
      $js_res .= $tbfrom->name . '_obj.addControlledEditor('.$objname.');'."\n";
      $js_res .= $objname.'.controlled_by = '.$tbfrom->name.'_obj;'."\n";
      // remove unused toolbars
      if ($other_present)
      {
        // remove other toolbar tags leaving inner content intact
        $tpl = preg_replace('/(\{SPAW TB=_OTHER\})(.*)(\{SPAW TOOLBAR\})(.*)(\{\/SPAW TB\})/sU', '$2$4', $tpl);
      }
      // remove all toolbar tags and inner code
      $tpl = preg_replace('/(\{SPAW TB=[^\}]*\})(.*)(\{\/SPAW TB\})/sU', '', $tpl);
      
      // pages and tabs
      // setup tab templates
      $tabtpl = '';
      $atabtpl = '';
      if (sizeof($this->pages)>1)
      {
        // tab template
        if (preg_match("/(\{SPAW TABSTRIP\})(.*)(\{SPAW TAB\})(.*)(\{\/SPAW TAB\})(.*)(\{\/SPAW TABSTRIP\})/sU", $tpl, $matches))
        {
          $tabtpl = $matches[4];
        }
        // active tab template
        if (preg_match("/(\{SPAW TABSTRIP\})(.*)(\{SPAW TAB ACTIVE\})(.*)(\{\/SPAW TAB\})(.*)(\{\/SPAW TABSTRIP\})/sU", $tpl, $matches))
        {
          $atabtpl = $matches[4];
        }
        // remove tabstrip markers and mark tab place
        $tpl = preg_replace('/(\{SPAW TABSTRIP\})(.*)(\{\/SPAW TABSTRIP\})/sU', '$2', $tpl);
        $tpl = preg_replace('/(\{SPAW TAB ACTIVE\})(.*)(\{\/SPAW TAB\})/sU', '{SPAW TABS}', $tpl);
        $tpl = preg_replace('/(\{SPAW TAB\})(.*)(\{\/SPAW TAB\})/sU', '', $tpl);
      }
      else
      {
        // tabs not needed, remove tab strip
        $tpl = preg_replace('/(\{SPAW TABSTRIP\})(.*)(\{\/SPAW TABSTRIP\})/sU', '', $tpl);
      }
      
      // mode strip
      if (strpos($tpl, '{SPAW MODESTRIP}'))
      {
        if ($this->isModeStripVisible())
        {
          // modestrip placeholder found
          $mstrip = SpawToolbar::getToolbar("mode_strip");
          $mstrip->editor = &$this;
          $tpl = preg_replace('/(\{SPAW MODESTRIP\})(.*)(\{SPAW MODES\})(.*)(\{\/SPAW MODESTRIP\})/sU', '$2'.$mstrip->renderToolbar($this->name, $this->theme).'$4', $tpl);
        }
        else
        {
          // just remove the placeholder
          $tpl = preg_replace('/(\{SPAW MODESTRIP\})(.*)(\{\/SPAW MODESTRIP\})/sU', '', $tpl);
        }
      }
  
      // statusbar
      if (strpos($tpl, '{SPAW STATUSBAR}'))
      {
        if ($this->isStatusBarVisible())
        {
          // modestrip placeholder found
          if ($this->isResizingGripVisible() && $this->config->getConfigValue('resizing_directions') != 'none')
          {
            $grip = '<img src="'.SpawConfig::getStaticConfigValue("SPAW_DIR").'plugins/core/lib/theme/'.$this->theme->name.'/img/sizing_grip.gif" border="0" style="cursor: se-resize;"';
            $grip .= ' onmousedown="'.$objname.'.resizingGripMouseDown(event);"';
            $grip .= ' unselectable="on"';
            $grip .= ' alt="" />';
          }
          else
          {
            $grip = '';
          } 
          $tpl = preg_replace('/(\{SPAW STATUSBAR\})(.*)(\{SPAW STATUS\})(.*)(\{SPAW SIZINGGRIP\})(.*)(\{\/SPAW STATUSBAR\})/sU', '$2<span id="'.$this->name.'_status"></span>$4'.$grip.'$6', $tpl);
        }
        else
        {
          // remove status bar placeholder
          $tpl = preg_replace('/(\{SPAW STATUSBAR\})(.*)(\{\/SPAW STATUSBAR\})/sU', '', $tpl);
        }
      }
  
  
      $pagetpl = '';
      $tabstpl = '';
      foreach($this->pages as $pname => $page)
      {
        $pagetpl .= '<textarea name="'.$page->inputName.'" id="'.$pname.'" style="width: 100%; height: '.$this->height.'; display: none; overflow: scroll;" rows="10" cols="10">'.htmlspecialchars($page->value).'</textarea>';
        $js_res .= 'var '.$pname.'_page = new SpawEditorPage("'.$pname.'","'.htmlspecialchars($page->caption).'","'.$page->direction.'");'."\n";
        //$js_res .= $pname.'_page.value = "'.htmlspecialchars($page->value).'";'."\n";
        $js_res .= $objname.'.addPage('.$pname.'_page);'."\n";
        $js_res .= $objname.'.getTab("'.$pname.'").template = "'.addslashes(str_replace("{SPAW TAB CAPTION}", $page->caption, $tabtpl)).'";'."\n";
        $js_res .= $objname.'.getTab("'.$pname.'").active_template = "'.addslashes(str_replace("{SPAW TAB CAPTION}", $page->caption, $atabtpl)).'";'."\n";
        if ($this->name == $pname)
          $js_res .= $objname.'.active_page ='.$pname.'_page;'."\n";
              
        $pagetpl .= '<iframe name="'.$pname.'_rEdit" id="'.$pname.'_rEdit" style="width: 100%; height: '.$this->height.'; display: '.(($this->name == $pname)?'inline':'none').';" frameborder="no" src="'.SpawConfig::getStaticConfigValue("SPAW_DIR").'empty/empty.html?'.microtime().'"></iframe>';
        $tabstpl .= '<span id="'.$pname.'_tab" style="cursor: default;" onclick="'.$objname.'.setActivePage(\''.$pname.'\');">'.str_replace("{SPAW TAB CAPTION}", $page->caption, ($pname == $this->name)?$atabtpl:$tabtpl).'</span>'; 
      }
      $tpl = str_replace('{SPAW EDITOR}', $pagetpl, $tpl);
  
      $tpl = str_replace('{SPAW TABS}',$tabstpl,$tpl);    
      
      $html_res .= '<table border="0" cellpadding="0" cellspacing="0" id="'.$this->name.'_enclosure" class="'.$this->theme->name.'" style="padding: 0px 0px 0px 0px; width: '.$this->width.';"><tr><td>'.$tpl.'</td></tr></table>';
      
      $js_res .= $objname.'.onLoadHookup();'."\n";
  
      $res = $head_res.'<script type="text/javascript" id="'.$pname.'_script">'."\n<!--\n".$js_res."\n//-->\n".'</script>'.$html_res;
    }
    else
    {
      // standard textarea fallback
      foreach($this->pages as $pname => $page)
      {
        if (sizeof($this->pages)>1)
          $res .= '<label for="'.$pname.'">'.$page->caption.'</label><br />';
        $res .= '<textarea name="'.$pname.'" id="'.$pname.'" width="'.$this->width.'" height="'.$this->height.'" style="width: '.$this->width.'; height: '.$this->height.';" wrap="off">'.htmlspecialchars($page->value).'</textarea><br />';
      }
    }
    return $res;
  }
  
  /**
   * Outputs editor's HTML code to the client
   */
  function show()
  {
    echo $this->getHtml();
  }             
                                                                                            
}

/**
 * Wrapper for seamless upgrade from v.1.x
 * @package spaw2
 * @subpackage Editor
 */
class SPAW_Wysiwyg extends SpawEditor 
{
  function SPAW_Wysiwyg($control_name='', $value='', $lang='', $mode = '',
              $theme='', $width='', $height='', $css_stylesheet='', $dropdown_data='')
  {
    // value translations
    switch($mode)
    {
      case 'default':
        $mode = 'standard';
        break;
      case 'full':
        $mode = 'all';
        break;
      case 'mini':
        $mode = 'mini';
        break;
      default:
        $mode = '';
        break;
    }
    parent::SpawEditor($control_name, $value, $lang, $mode, '', $width, $height, $css_stylesheet);
    
    if ($mode == 'mini')
      $this->hideStatusBar();
  }
}
?>
