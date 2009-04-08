<?php
/**
 * SPAW Editor v.2 Toolbar classes
 * 
 * Toolbar related classes
 *   
 * @package spaw2
 * @subpackage Toolbar  
 * @author Alan Mendelevich <alan@solmetra.lt> 
 * @copyright UAB Solmetra
 *  
 * @todo implement get methods
 */ 

require_once(str_replace('\\\\','/',dirname(__FILE__)).'/util.class.php');

/**
 * Specifies that toolbar item is a static image
 */ 
define("SPAW_TBI_IMAGE", "image");
/**
 * Specifies that toolbar item is a button (active image)
 */ 
define("SPAW_TBI_BUTTON", "button");
/**
 * Specifies that toolbar item is a dropdown list
 */ 
define("SPAW_TBI_DROPDOWN", "dropdown");

/**
 * Toolbar item base class
 * 
 * Defines variables and methods shared by all types of toolbar items
 * @package spaw2
 * @subpackage Toolbar
 */     
class SpawTbItem
{
  /**
   * Module (plugin) name
   * @var string  
   */
  var $module;     
  /**
   * Item name
   * @var string
   */        
  var $name;
  /**
   * Supported agent (browser)
   * @var integer
   * @see SPAW_AGENT_UNSUPPORTED, SPAW_AGENT_IE, SPAW_AGENT_GECKO, SPAW_AGENT_ALL          
   */
  var $agent;        
  
  /**
   * Initializes toolbar item object with specified values
   * @param string $module module (plugin) name
   * @param string $name item name
   * @param integer $agent supported agent (browser). Default {@link SPAW_AGENT_ALL} 
   * @see SPAW_AGENT_UNSUPPORTED, SPAW_AGENT_IE, SPAW_AGENT_GECKO, SPAW_AGENT_ALL          
   */
  function SpawTbItem($module, $name, $agent=SPAW_AGENT_ALL)
  {
    $this->module = $module;
    $this->name = $name;
    $this->agent = $agent;
  }
  
  /**
   * Returns client code for toolbar item
   * @returns string
   */
  function get()
  {
    // todo
  }                                
}

/**
 * Represents static toolbar image
 * 
 * @package spaw2
 * @subpackage Toolbar
 */    
class SpawTbImage extends SpawTbItem
{
  /**
   * Returns client code for toolbar image (override)
   * @returns string
   */
  function get()
  {
    // todo
  }        
}

/**
 * Represents toolbar button
 * @package spaw2
 * @subpackage Toolbar
 */
class SpawTbButton extends SpawTbItem
{
  /**
   * Name of the javascript function returning true if button should be enabled
   * @var string
   */        
  var $on_enabled_check;
  /**
   * Name of the javascript function returning if the button should be pushed
   * @var string
   */
  var $on_pushed_check;
  /**
   * Name of the javascript function to be called on button click
   * @var string
   */
  var $on_click;          
  /**
   * Hold value whether toolbar item should be added to context menu
   * @var bool
   */
  var $show_in_context_menu = false;              
  /**
   * Initializes toolbar button object
   * @param string $module module (plugin) name
   * @param string $name item name
   * @param string $on_enabled_check name of the javascript function returning true if button should be enabled
   * @param string $on_pushed_check name of the javascript function returning if the button should be pushed
   * @param string $on_click name of the javascript function to be called on button click
   * @param integer $agent supported agent (browser). Default {@link SPAW_AGENT_ALL} 
   * @see SPAW_AGENT_UNSUPPORTED, SPAW_AGENT_IE, SPAW_AGENT_GECKO, SPAW_AGENT_ALL          
   */        
  function SpawTbButton($module, $name, $on_enabled_check, $on_pushed_check, $on_click, $agent=SPAW_AGENT_ALL, $show_in_context_menu=false)
  {
    parent::SpawTbItem($module, $name, $agent);
    $this->on_enabled_check = $on_enabled_check;
    $this->on_pushed_check = $on_pushed_check;
    $this->on_click = $on_click;
    $this->show_in_context_menu = $show_in_context_menu; 
  }
  /**
   * Returns client code for toolbar button (override)
   * @returns string
   */
  function get()
  {
    // todo
  }        
}   

/**
 * Represents toolbar dropdown
 * @package spaw2
 * @subpackage Toolbar
 */
class SpawTbDropdown extends SpawTbItem
{
  /**
   * Holds array of dropdown items (key represents value, value represents text)
   * @var array
   */        
  var $data;
  /**
   * Name of the javascript function returning true if dropdown should be enabled
   * @var string
   */        
  var $on_enabled_check;
  /**
   * Name of the javascript function returning value that should be selected in dropdown
   * @var string
   */
  var $on_status_check;
  /**
   * Name of the javascript function to be called when value of the dropdown has changed
   * @var string
   */
  var $on_change;                
  /**
   * Initializes dropdown object
   * @param string $module module (plugin) name
   * @param string $name item name
   * @param string $on_enabled_check name of the javascript function returning true if dropdown should be enabled
   * @param string $on_status_check name of the javascript function returning value that should be selected in dropdown
   * @param string $on_change name of the javascript function to be called when value of the dropdown has changed
   * @param array $data array of dropdown items (key represents value, value represents text)   
   * @param integer $agent supported agent (browser). Default {@link SPAW_AGENT_ALL} 
   * @see SPAW_AGENT_UNSUPPORTED, SPAW_AGENT_IE, SPAW_AGENT_GECKO, SPAW_AGENT_ALL          
   */        
  function SpawTbDropdown($module, $name, $on_enabled_check, $on_status_check, $on_change, $data='', $agent=SPAW_AGENT_ALL) 
  {
    parent::SpawTbItem($module, $name, $agent);
    if (is_array($data))
      $this->data = $data;
    $this->on_enabled_check = $on_enabled_check;
    $this->on_status_check = $on_status_check;
    $this->on_change = $on_change;
  }
  /**
   * Returns client code for dropdown (override)
   * @returns string
   */
  function get()
  {
    // todo
  }        
}

/**
 * Represents single toolbar
 * 
 * Single toolbar is a set of toolbar items typically grouped by kind of function
 * @package spaw2
 * @subpackage Toolbar
 */
class SpawToolbar
{
  /**
   * Toolbar name
   * @var string
   */        
  var $name;
  /**
   * Holds toolbar items
   * @var array
   */        
  var $items;
  /**
   * Holds reference to editor toolbars belongs to
   * @var SpawEditor
   */
  var $editor;        
  /**
   * Initializes toolbar object
   * @param string $name toolbar name
   */        
  function SpawToolbar($name)
  {
    $this->name = $name;
    $this->items = array();
  }
  
  /**
   * Returns toolbar object
   * @param string $name toolbar name
   * @returns SpawToolbar
   * @static
   */
  function getToolbar($name)
  {
    $tb = new SpawToolbar($name);
    $tb->loadData();
    return $tb;
  }
  
  /**
   * Loads toolbar data
   * @access protected
   */
  function loadData()
  {
    $pgdir = SpawConfig::getStaticConfigValue("SPAW_ROOT").'plugins/';
    if (is_dir($pgdir)) 
    {
     if ($dh = opendir($pgdir)) 
     {
       while (($pg = readdir($dh)) !== false) 
       {
        if (file_exists($pgdir.$pg.'/lib/toolbars/'.$this->name.'.toolbar.php'))
        {
          // load toolbar file for each plugin
          include($pgdir.$pg.'/lib/toolbars/'.$this->name.'.toolbar.php');
          if ($pg != 'core')
          {
            // some plugin... append items to the end
            $this->items = array_merge($this->items, $items);
          }
          else
          {
            // core... insert items in the beginning
            $this->items = array_merge($items, $this->items);
          }
          unset($items);
        }
       }
       closedir($dh);
     }
    }    
  }
  
  /**
   * Renders code for specified toolbar
   * @param string $prefix prefix to use for id's (editor name)
   * @param SpawTheme $theme theme/skin to use   
   * @returns string   
   */
  function renderToolbar($prefix, $theme)
  {
    $js_res = '';
    $html_res = '<span style="white-space: nowrap;">';
    $pgdir = SpawConfig::getStaticConfigValue("SPAW_DIR").'plugins/';
    $i = 0; 
    if ($this->items)
    {
      foreach($this->items as $obj)
      {
        if (is_object($obj) && ($obj->agent & SpawAgent::getAgent()))
        {
          $id = $prefix.'_'.$this->name.'_'.$i;
          switch(strtolower(get_class($obj)))
          {
            case "spawtbimage":
            {
              $js_res .= $prefix.'_obj.addToolbarItem(new SpawTbImage("'.$obj->module.'","'.$obj->name.'","'.$id.'"),"'.$this->name.'");';
              $html_res .= '<img id="'.$id.'" src="'.$pgdir.$obj->module.'/lib/theme/'.$theme->name.'/img/tb_'.$obj->name.'.gif"';
              if ($theme->isCustomStyleTbi($obj->name))
                $html_res .= ' style="' . $theme->getCustomTbiStyle($obj->name) . '"';
              elseif ($theme->getDefaultTbImageStyle())
                $html_res .= ' style="' . $theme->getDefaultTbImageStyle() . '"'; 
              if ($theme->isCustomCssClassTbi($obj->name))
                $html_res .= ' class="' . $theme->getCustomTbiCssClass($obj->name) . '"';
              elseif ($theme->getDefaultTbImageCssClass())
                $html_res .= ' class="' . $theme->getDefaultTbImageCssClass() . '"';
                
              $html_res .= ' alt="" />';
              break;
            }
            case "spawtbbutton":
            {
              $img_src = $obj->module.'/lib/theme/'.$theme->name.'/img/tb_'.$obj->name.'.gif';
              if (!file_exists(SpawConfig::getStaticConfigValue("SPAW_ROOT").'plugins/'.$img_src))
              {
                // use default plugin button
                $img_src = 'core/lib/theme/'.$theme->name.'/img/tb__plugin.gif';
              } 
              
              $js_res .= $prefix.'_obj.addToolbarItem(new SpawTbButton("'.$obj->module.'","'.$obj->name.'","'.$id.'","'.$obj->on_enabled_check.'","'.$obj->on_pushed_check.'","'.$obj->on_click.'","'.$pgdir.$img_src.'",'.($obj->show_in_context_menu?"true":"false").'),"'.$this->name.'");';
                
              $html_res .= '<img id="'.$id.'" src="'.$pgdir.$img_src.'"';
              if ($theme->isCustomStyleTbi($obj->name))
                $html_res .= ' style="' . $theme->getCustomTbiStyle($obj->name) . ' cursor: default;"';
              elseif ($theme->getDefaultTbButtonStyle())
                $html_res .= ' style="' . $theme->getDefaultTbButtonStyle() . ' cursor: default;"';
              else
                $html_res .= ' style="cursor: default;"';
              if ($theme->isCustomCssClassTbi($obj->name))
                $html_res .= ' class="' . $theme->getCustomTbiCssClass($obj->name) . '"';
              elseif ($theme->getDefaultTbButtonCssClass())
                $html_res .= ' class="' . $theme->getDefaultTbButtonCssClass() . '"';
              $html_res .= ' onclick="SpawPG'.$obj->module.'.'.$obj->on_click.'('.$prefix.'_obj.getTargetEditor(),'.$prefix.'_obj.getToolbarItem(\''.$id.'\'), this);"'; 
              $html_res .= ' onmouseover="'.$prefix.'_obj.theme.buttonOver('.$prefix.'_obj.getToolbarItem(\''.$id.'\'), this);"'; 
              $html_res .= ' onmouseout="'.$prefix.'_obj.theme.buttonOut('.$prefix.'_obj.getToolbarItem(\''.$id.'\'), this);"'; 
              $html_res .= ' onmousedown="'.$prefix.'_obj.theme.buttonDown('.$prefix.'_obj.getToolbarItem(\''.$id.'\'), this);"'; 
              $html_res .= ' onmouseup="'.$prefix.'_obj.theme.buttonUp('.$prefix.'_obj.getToolbarItem(\''.$id.'\'), this);"';
              $html_res .= ' alt="'.$this->editor->lang->m('title',$obj->name,$obj->module).'"'; 
              $html_res .= ' title="'.$this->editor->lang->m('title',$obj->name,$obj->module).'"'; 
              $html_res .= ' unselectable="on"'; 
              $html_res .= ' />';
              break;
            }
            case "spawtbdropdown":
            {
              if (empty($obj->data))
              {
                // try getting data from config
                $obj->data = $this->editor->config->getConfigValue('dropdown_data_'.$obj->module.'_'.$obj->name);
              }
              if (is_array($obj->data))
              {
                $js_res .= $prefix.'_obj.addToolbarItem(new SpawTbDropdown("'.$obj->module.'","'.$obj->name.'","'.$id.'","'.$obj->on_enabled_check.'","'.$obj->on_status_check.'","'.$obj->on_change.'"),"'.$this->name.'");';

                $html_res .= '<select size="1" id="'.$id.'" ';
                if ($theme->isCustomStyleTbi($obj->name))
                  $html_res .= ' style="' . $theme->getCustomTbiStyle($obj->name) . '"';
                elseif ($theme->getDefaultTbDropdownStyle())
                  $html_res .= ' style="' . $theme->getDefaultTbDropdownStyle() . '"';
                if ($theme->isCustomCssClassTbi($obj->name))
                  $html_res .= ' class="' . $theme->getCustomTbiCssClass($obj->name) . '"';
                elseif ($theme->getDefaultTbDropdownCssClass())
                  $html_res .= ' class="' . $theme->getDefaultTbDropdownCssClass() . '"';
                $html_res .= ' onchange="SpawPG'.$obj->module.'.'.$obj->on_change.'('.$prefix.'_obj.getTargetEditor(),'.$prefix.'_obj.getToolbarItem(\''.$id.'\'), this);"'; 
                $html_res .= ' onmouseover="'.$prefix.'_obj.theme.dropdownOver('.$prefix.'_obj.getToolbarItem(\''.$id.'\'), this);"'; 
                $html_res .= ' onmouseout="'.$prefix.'_obj.theme.dropdownOut('.$prefix.'_obj.getToolbarItem(\''.$id.'\'), this);"'; 
                $html_res .= ' onmousedown="'.$prefix.'_obj.theme.dropdownDown('.$prefix.'_obj.getToolbarItem(\''.$id.'\'), this);"'; 
                $html_res .= ' onmouseup="'.$prefix.'_obj.theme.dropdownUp('.$prefix.'_obj.getToolbarItem(\''.$id.'\'), this);"'; 
                $html_res .= '>';
                $html_res .= '<option>'.$this->editor->lang->m('title',$obj->name,$obj->module).'</option>'; 
                foreach($obj->data as $key => $value)
                {
                  $html_res .= '<option value="'.$key.'">'.$value.'</option>'; 
                }
                $html_res .= '</select>';
              }
            }
          }
        }
        $i++;
      }
      $html_res .= '</span>';
      $res = '<script type="text/javascript">'."\n<!--\n".$js_res."\n//-->\n".'</script>'.$html_res;
      return $res;
    }
  }
  
                         
}       

?>
