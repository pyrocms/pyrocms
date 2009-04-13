<?php
/**
 * SPAW Editor v.2 Theme classes
 * 
 * Theme (skin) related classes
 *   
 * @package spaw2
 * @subpackage Theme  
 * @author Alan Mendelevich <alan@solmetra.lt> 
 * @copyright UAB Solmetra
 */ 

require_once(str_replace('\\\\','/',dirname(__FILE__)).'/config.class.php');

/**
 * Theme (skin) class
 * 
 * Stores and retrieves data related to editor themes (skins)
 * @package spaw2
 * @subpackage Theme
 */     
class SpawTheme
{
  /**
   * Name of the theme
   * @access private
   * @var string
   */           
  var $name;
  
  /**
   * Returns the name of the theme
   * @returns string
   */        
  function getName()
  {
    return $this->name;
  }
  
  /**
   * Initializes Theme object
   * @param string @name Theme name
   */
  function SpawTheme($name)
  {
    $this->name = $name;
  }

  /**
   * Returns Theme object
   * @param string $name Theme name
   * @returns SpawTheme SpawTheme object   
   * @static
   */
  function getTheme($name)
  {
    if (strpos($name, '/') || strpos($name, "\\")) die("illegal theme name");
    $theme = new SpawTheme($name);
    $theme->loadData();
    return $theme;
  }
             
  /**
   * Default toolbar button style
   * @access private   
   * @var string
   */
  var $default_tb_button_style;
  /**
   * Sets default toolbar button style
   * @param string $style Style string
   */           
  function setDefaultTbButtonStyle($style)
  {
    $this->default_tb_button_style = $style;
  }
  /**
   * Returns default toolbar button style
   * @returns string
   */           
  function getDefaultTbButtonStyle()
  {
    return $this->default_tb_button_style;
  }
  /**
   * Default toolbar image style
   * @var string
   */
  var $default_tb_image_style;
  /**
   * Sets default toolbar image style
   * @param string $style Style string
   */           
  function setDefaultTbImageStyle($style)
  {
    $this->default_tb_image_style = $style;
  }
  /**
   * Returns default toolbar image style
   * @returns string
   */           
  function getDefaultTbImageStyle()
  {
    return $this->default_tb_image_style;
  }
  /**
   * Default toolbar dropdown style
   * @var string
   */
  var $default_tb_dropdown_style;
  /**
   * Sets default toolbar dropdown style
   * @param string $style Style string
   */           
  function setDefaultTbDropdownStyle($style)
  {
    $this->default_tb_dropdown_style = $style;
  }
  /**
   * Returns default toolbar dropdown style
   * @returns string
   */           
  function getDefaultTbDropdownStyle()
  {
    return $this->default_tb_dropdown_style;
  }

  /**
   * Stores custom styles for specific toolbar items
   * @access private
   * @var array
   */           
  var $custom_tbi_styles = array();
  /**
   * Returns true if specified toolbar item has custom style
   * @param string $name Toolbar item name
   * @returns bool
   */           
  function isCustomStyleTbi($name)
  {
    if (isset($this->custom_tbi_styles[$name]))
      return true;
    else
      return false;
  }
  /**
   * Returns custom style for specified toolbar item
   * @param string $name Toolbar item name
   * @returns string
   */           
  function getCustomTbiStyle($name)
  {
    if (isset($this->custom_tbi_styles[$name]))
      return $this->custom_tbi_styles[$name];
    else
      return NULL;
  }

  /**
   * Default toolbar button CSS class
   * @access private   
   * @var string
   */
  var $default_tb_button_css_class;
  /**
   * Sets default toolbar button CSS class
   * @param string $css_class CssClass string
   */           
  function setDefaultTbButtonCssClass($css_class)
  {
    $this->default_tb_button_css_class = $css_class;
  }
  /**
   * Returns default toolbar button CSS class
   * @returns string
   */           
  function getDefaultTbButtonCssClass()
  {
    return $this->default_tb_button_css_class;
  }
  /**
   * Default toolbar image CSS class
   * @var string
   */
  var $default_tb_image_css_class;
  /**
   * Sets default toolbar image CSS class
   * @param string $css_class CssClass string
   */           
  function setDefaultTbImageCssClass($css_class)
  {
    $this->default_tb_image_css_class = $css_class;
  }
  /**
   * Returns default toolbar image CSS class
   * @returns string
   */           
  function getDefaultTbImageCssClass()
  {
    return $this->default_tb_image_css_class;
  }
  /**
   * Default toolbar dropdown CSS class
   * @var string
   */
  var $default_tb_dropdown_css_class;
  /**
   * Sets default toolbar dropdown CSS class
   * @param string $css_class CssClass string
   */           
  function setDefaultTbDropdownCssClass($css_class)
  {
    $this->default_tb_dropdown_css_class = $css_class;
  }
  /**
   * Returns default toolbar dropdown CSS class
   * @returns string
   */           
  function getDefaultTbDropdownCssClass()
  {
    return $this->default_tb_dropdown_css_class;
  }

  /**
   * Stores custom CSS classs for specific toolbar items
   * @access private
   * @var array
   */           
  var $custom_tbi_css_classes = array();
  /**
   * Returns true if specified toolbar item has custom CSS class
   * @param string $name Toolbar item name
   * @returns bool
   */           
  function isCustomCssClassTbi($name)
  {
    if (isset($this->custom_tbi_css_classes[$name]))
      return true;
    else
      return false;
  }
  /**
   * Returns custom CSS class for specified toolbar item
   * @param string $name Toolbar item name
   * @returns string
   */           
  function getCustomTbiCssClass($name)
  {
    if (isset($this->custom_tbi_css_classes[$name]))
      return $this->custom_tbi_css_classes[$name];
    else
      return NULL;
  }


  /**
   * Default toolbar button events
   * @access private   
   * @var array
   */
  var $default_tb_button_events;
  /**
   * Sets default toolbar button events
   * @param array $events array representing events (key) and their respective handler functions (value)
   */           
  function setDefaultTbButtonEvents($events)
  {
    $this->default_tb_button_events = $events;
  }
  /**
   * Returns default toolbar button events
   * @returns array
   */           
  function getDefaultTbButtonEvents()
  {
    return $this->default_tb_button_events;
  }

  /**
   * Stores custom events for specific toolbar items
   * @access private
   * @var array
   */           
  var $custom_tbi_events = array();
  /**
   * Returns true if specified toolbar item has custom events
   * @param string $name Toolbar item name
   * @returns bool
   */           
  function isCustomEventsTbi($name)
  {
    if (isset($this->custom_tbi_events[$name]))
      return true;
    else
      return false;
  }
  /**
   * Returns custom events for specified toolbar item
   * @param string $name Toolbar item name
   * @returns string
   */           
  function getCustomTbiEvents($name)
  {
    if (isset($this->custom_tbi_events[$name]))
      return $this->custom_tbi_events[$name];
    else
      return NULL;
  }



  /**
   * Holds editor layout template
   * @var string
   * @access private   
   */
  var $template;
  
  /**
   * Sets template variable
   * @param string $template Template code
   */
  function setTemplate($template)
  {
    $this->template = $template;
  }
  
  /**
   * Returns layout template
   * @returns string
   */
  function getTemplate()
  {
    return $this->template;
  }        
                  
  /**
   * Holds editor layout template when in floating mode
   * @var string
   * @access private   
   */
  var $template_floating;
  
  /**
   * Sets editor template variable for floating mode 
   * @param string $template Template code
   */
  function setTemplateFloating($template)
  {
    $this->template_floating = $template;
  }
  
  /**
   * Returns editor layout template for floating toolbar mode
   * @returns string
   */
  function getTemplateFloating()
  {
    return $this->template_floating;
  }        
                  
  /**
   * Holds toolbar layout template when in floating mode
   * @var string
   * @access private   
   */
  var $template_toolbar;
  
  /**
   * Sets toolbar template variable for floating mode 
   * @param string $template Template code
   */
  function setTemplateToolbar($template)
  {
    $this->template_toolbar = $template;
  }
  
  /**
   * Returns toolbar layout template for floating toolbar mode
   * @returns string
   */
  function getTemplateToolbar()
  {
    return $this->template_toolbar;
  }        

  /**
   * Holds standard template for dialog header
   * @var string
   * @access private   
   */
  var $template_dialog_header;
  
  /**
   * Sets standard template for dialog header 
   * @param string $template Template code
   */
  function setTemplateDialogHeader($template)
  {
    $this->template_dialog_header = $template;
  }
  
  /**
   * Returns standard template for dialog header
   * @returns string
   */
  function getTemplateDialogHeader()
  {
    return $this->template_dialog_header;
  }        

  /**
   * Holds standard template for dialog footer
   * @var string
   * @access private   
   */
  var $template_dialog_footer;
  
  /**
   * Sets standard template for dialog footer 
   * @param string $template Template code
   */
  function setTemplateDialogFooter($template)
  {
    $this->template_dialog_footer = $template;
  }
  
  /**
   * Returns standard template for dialog footer
   * @returns string
   */
  function getTemplateDialogFooter()
  {
    return $this->template_dialog_footer;
  }        


  /**
   * Loads theme data
   * @access private
   */
  function loadData()
  {
    if (strpos($this->name, '/') || strpos($this->name, "\\")) die("illegal theme name");
    $pgdir = SpawConfig::getStaticConfigValue("SPAW_ROOT").'plugins/';
    if (is_dir($pgdir)) {
     // load theme settings
     if ($dh = opendir($pgdir)) {
       while (($pg = readdir($dh)) !== false) {
        if (file_exists($pgdir.$pg.'/lib/theme/'.$this->name.'/config/theme.config.php'))
        {
          // load theme config file for each plugin
          include($pgdir.$pg.'/lib/theme/'.$this->name.'/config/theme.config.php');
          // load default styles for "core" only
          if ($pg == "core")
          {
            if (isset($default_tb_button_style))
            {
              $this->default_tb_button_style = $default_tb_button_style;
              unset($default_tb_button_style);
            }
            if (isset($default_tb_image_style))
            {
              $this->default_tb_image_style = $default_tb_image_style;
              unset($default_tb_image_style);
            }
            if (isset($default_tb_dropdown_style))
            {
              $this->default_tb_dropdown_style = $default_tb_dropdown_style;
              unset($default_tb_dropdown_style);
            }
            if (isset($default_tb_button_css_class))
            {
              $this->default_tb_button_css_class = $default_tb_button_css_class;
              unset($default_tb_button_css_class);
            }
            if (isset($default_tb_image_css_class))
            {
              $this->default_tb_image_css_class = $default_tb_image_css_class;
              unset($default_tb_image_css_class);
            }
            if (isset($default_tb_dropdown_css_class))
            {
              $this->default_tb_dropdown_css_class = $default_tb_dropdown_css_class;
              unset($default_tb_dropdown_css_class);
            }
            if (isset($default_tb_button_events))
            {
              $this->default_tb_button_events = $default_tb_button_events;
              unset($default_tb_button_events);
            }
          }
          if (isset($custom_tbi_styles))
          {
            $this->custom_tbi_styles = array_merge($this->custom_tbi_styles, $custom_tbi_styles);
            unset($custom_tbi_styles);
          }
          if (isset($custom_tbi_css_classes))
          {
            $this->custom_tbi_css_classes = array_merge($this->custom_tbi_css_classes, $custom_tbi_css_classes);
            unset($custom_tbi_css_classes);
          }
          if (isset($custom_tbi_events))
          {
            $this->custom_tbi_events = array_merge($this->custom_tbi_events, $custom_tbi_events);
            unset($custom_tbi_events);
          }
        }
       }
       closedir($dh);
     }
     // load template
     if (file_exists($pgdir."core/lib/theme/".$this->name."/templates/editor.tpl"))
     {
      $fn = $pgdir."core/lib/theme/".$this->name."/templates/editor.tpl";
      $handle = fopen($fn, "r");
      $this->template = fread($handle, filesize($fn));
      fclose($handle);
     }
     // load editor template for floating toolbar mode
     if (file_exists($pgdir."core/lib/theme/".$this->name."/templates/editor_floating.tpl"))
     {
      $fn = $pgdir."core/lib/theme/".$this->name."/templates/editor_floating.tpl";
      $handle = fopen($fn, "r");
      $this->template_floating = fread($handle, filesize($fn));
      fclose($handle);
     }
     // load toolbar template for floating toolbar mode
     if (file_exists($pgdir."core/lib/theme/".$this->name."/templates/toolbar_floating.tpl"))
     {
      $fn = $pgdir."core/lib/theme/".$this->name."/templates/toolbar_floating.tpl";
      $handle = fopen($fn, "r");
      $this->template_toolbar = fread($handle, filesize($fn));
      fclose($handle);
     }
     // load template for standard dialog header
     if (file_exists($pgdir."core/lib/theme/".$this->name."/templates/dialog_header.tpl"))
     {
      $fn = $pgdir."core/lib/theme/".$this->name."/templates/dialog_header.tpl";
      $handle = fopen($fn, "r");
      $this->template_dialog_header = fread($handle, filesize($fn));
      fclose($handle);
     }
     // load template for standard dialog footer
     if (file_exists($pgdir."core/lib/theme/".$this->name."/templates/dialog_footer.tpl"))
     {
      $fn = $pgdir."core/lib/theme/".$this->name."/templates/dialog_footer.tpl";
      $handle = fopen($fn, "r");
      $this->template_dialog_footer = fread($handle, filesize($fn));
      fclose($handle);
     }
    }    
  }                
}
?>
