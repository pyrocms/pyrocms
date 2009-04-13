<?php
/**
 * SPAW Editor v.2 Standard dialog window
 *
 * Standard dialog window 
 * @package spaw2
 * @subpackage Dialogs  
 * @author Alan Mendelevich <alan@solmetra.lt> 
 * @copyright UAB Solmetra
 */ 
error_reporting(E_ALL);
include_once("../spaw.inc.php");
$module = SpawVars::getGetVar("module");
if (strpos($module, '/') || strpos($module, "\\")) die("illegal module name");
$dialog = SpawVars::getGetVar("dialog");
if (strpos($dialog, '/') || strpos($dialog, "\\")) die("illegal dialog name");
$lang = new SpawLang(SpawVars::getGetVar("lang"));
$charset = $lang->getCharset(); 
if (SpawVars::getGetVar('charset') != '')
{
  $charset = SpawVars::getGetVar('charset'); 
  $lang->setOutputCharset($charset);
}

if (SpawVars::getGetVar("scid") != '' && session_id() == '')
  session_start();
$config = new SpawConfig();
$config->restoreSecureConfig(SpawVars::getGetVar("scid"));

$theme = SpawTheme::getTheme(SpawVars::getGetVar("theme"));
$htpl = $theme->getTemplateDialogHeader();
$htpl = str_replace('{SPAW DIALOG TITLE}', $lang->m('title', $dialog, $module), $htpl); 
$htpl = str_replace('{SPAW DIR}', SpawConfig::getStaticConfigValue('SPAW_DIR'), $htpl);
$ftpl = $theme->getTemplateDialogFooter(); 
$ftpl = str_replace('{SPAW DIR}', SpawConfig::getStaticConfigValue('SPAW_DIR'), $ftpl);

ob_start();
?>
<html>
<head>
<title><?php echo $lang->m('title', $dialog, $module) ?></title>
<meta http-equiv="content-type" content="text/html;charset=<?php echo $charset ?>" />
<script type="text/javascript" src="../js/spaw.js.php"></script>
<script type="text/javascript">
<!--
SpawEngine.spaw_dir = "<?php echo SpawConfig::getStaticConfigValue('SPAW_DIR') ?>";
SpawEngine.setPlatform('php');

function SpawDialog()
{
}
SpawDialog.resizeDialogToContent = function()
{
  if (window.sizeToContent)
  {
    // gecko
    window.sizeToContent();
  }
  else
  {
    // resize window so there are no scrollbars visible
    if (!spawEditor._dialog_chrome_width)
    {
      // do these calculations only once for each spaw instance on a page
      window.resizeTo(600, 500);
      spawEditor._dialog_chrome_width = 600 - document.body.clientWidth;
      spawEditor._dialog_chrome_height = 500 - document.body.clientHeight;
    }
    window.resizeTo(50, 40);
    window.resizeTo(document.body.scrollWidth + spawEditor._dialog_chrome_width, document.body.scrollHeight + spawEditor._dialog_chrome_height);
    
  }
}

var spawArgs;
var spawEditor;
var spawArguments;

SpawDialog.dialogInit = function()
{
  if (window.opener)
  {
    spawArgs = window.opener.dialogArguments;
    if (spawArgs == null)
      window.close();
    spawEditor = spawArgs.editor;
    spawArguments = spawArgs.arguments;
  }

  if (window.history.length == 0 || (window.sizeToContent && window.history.length == 1 /* Gecko */) || (navigator.vendor && navigator.vendor.indexOf('Apple')>-1 && window.history.length == 1) /* Safari */) // no need to resize and center on reloads
  {
    SpawDialog.resizeDialogToContent();
    // center according to new dimensions
    window.moveTo(screen.availWidth/2 - document.body.clientWidth/2, screen.availHeight/2 - document.body.clientHeight/2);
  }
}

SpawDialog.returnValue = function(result)
{
  if (spawArgs.callback)
  {
    eval('window.opener.'+spawArgs.callback + '(spawEditor, result, spawArgs.tbi, spawArgs.sender)');
  }
}
//-->
</script>
</head>
<body onload="SpawDialog.dialogInit();" dir="<?php echo $lang->getDir() ?>">
<?php echo $htpl ?>
<?php include(SpawConfig::getStaticConfigValue('SPAW_ROOT').'plugins/'.$module.'/dialogs/'.$dialog.'.inc.php'); ?>
<?php echo $ftpl ?>
</body>
</html>
<?php
ob_end_flush();
?>
