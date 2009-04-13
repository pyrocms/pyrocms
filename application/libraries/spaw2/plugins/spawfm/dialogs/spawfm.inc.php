<?php
error_reporting(E_ALL);
function dbg($var) {
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}

/////////////////////////////////////

$lang->setModule('spawfm');

// load environment variables
$settings = $config->getConfigValue('PG_SPAWFM_SETTINGS');
$filetypes = $config->getConfigValue('PG_SPAWFM_FILETYPES');
$dir_list = $config->getConfigValue('PG_SPAWFM_DIRECTORIES');
$doc_root = $config->getConfigValue('DOCUMENT_ROOT');
if (preg_match('|[\\/]$|', $doc_root))
  $doc_root = substr($doc_root, 0, -1);
$imgdir = $config->getConfigValue('SPAW_DIR').'plugins/spawfm/lib/theme/'.$theme->name.'/img/';

require_once($config->getConfigValue('SPAW_ROOT').'plugins/spawfm/class/spawfm.class.php');
$spawfm = new SpawFm();

$error_msg = '';

// set default "global" settings if not set by user
if (!isset($settings['allow_upload']))
  $settings['allow_upload'] = false;
if (!isset($settings['allow_modify']))
  $settings['allow_modify'] = false;
if (!isset($settings['max_upload_filesize']))
  $settings['max_upload_filesize'] = 0;
if (!isset($settings['allowed_filetypes']))
  $settings['allowed_filetypes'] = array('any');
if (!isset($settings['chmod_to']))
  $settings['chmod_to'] = false;
if (!isset($settings['max_img_width']))
  $settings['max_img_width'] = 0;
if (!isset($settings['max_img_height']))
  $settings['max_img_height'] = 0;
if (!isset($settings['recursive']))
  $settings['recursive'] = false;
if (!isset($settings['allow_modify_subdirectories']))
  $settings['allow_modify_subdirectories'] = false;
if (!isset($settings['allow_create_subdirectories']))
  $settings['allow_create_subdirectories'] = false;

// fetch context variables
$tmp = explode($config->getConfigValue('spawfm_path_separator'), SpawVars::getPostVar('dir') ? SpawVars::getPostVar('dir') : SpawVars::getGetVar('dir'));
$curr_dir = SpawFm::normalizeDir($tmp[0], true);
$curr_dir_subdir = isset($tmp[1]) ? $tmp[1] : false;

$curr_type = SpawVars::getPostVar('type') ? SpawVars::stripSlashes(SpawVars::getPostVar('type')) : SpawVars::stripSlashes(SpawVars::getGetVar('type'));
if ($curr_type == '*')
  $curr_type = false;
$type_fixed = SpawVars::getGetVar('nofilter');

// build directories list, determine selected option
$dirs = array();
$curr_dir_pos = false;
$all_types = array();
foreach ($dir_list as $dirpos=>$dirdef) {
  if (is_string($dirdef)) { // simple dir definition
    $dir = $caption = $dirdef;
    $dir = SpawFm::normalizeDir($dir);
    $fsdir = $doc_root.$dir;
    $params = $settings;
  } elseif (is_array($dirdef) and isset($dirdef['dir'])) { // advanced dir definition
    $dir = $dirdef['dir'];
    $caption = (!empty($dirdef['caption'])) ? $dirdef['caption'] : $dir;
    $params = (!empty($dirdef['params'])) ? array_merge($settings, $dirdef['params']) : $settings;
    $dir = SpawFm::normalizeDir($dir);
    if (empty($dirdef['fsdir'])) {
      $fsdir = $doc_root.$dir;
    } else {
      $fsdir = SpawFm::normalizeDir($dirdef['fsdir'], false, true);
    }
  } else {
    $dir = false; 
  }

  if ($dir and file_exists($fsdir)) {
    $dir_data = array(
      'dir'     => $dir,
      'fsdir'   => $fsdir,
      'caption' => $caption,
      'params'  => $params,
    );
    $dirs[] = $dir_data;
    // set default dir if needed
    if (!$curr_dir and !empty($params['default_dir'])) {
      $curr_dir = $dir;
    }
    
    // track filetypes allowed
    if (is_array($params['allowed_filetypes'])) {
      $all_types = array_merge($all_types, $params['allowed_filetypes']);
    } else {
      $all_types[] = $params['allowed_filetypes'];
    }
    
    // load current directory data
    if ($dir == $curr_dir) {
      $spawfm->setCurrentDirData($dir_data);
      $curr_dir_pos = $dirpos;
    }
  }
}

// cleanup filetypes array
$all_types = array_unique($all_types);
foreach ($all_types as $key=>$type) {
  if ($type{0} == '.' or $type == 'any' or !isset($filetypes[$type])) {
    unset($all_types[$key]);
  }
}
// check selected type for validity
if ($curr_type and (!in_array($curr_type, $all_types) or !isset($filetypes[$curr_type]))) {
  $curr_type = false;
} else {
  $spawfm->setCurrentType($curr_type);
}

// filter out directories not matching current type, reset $curr_dir if needed
if ($curr_type) {
  $curr_dir_reset = false;
  foreach ($dirs as $key=>$val) {
    if (empty($val['params']['allowed_filetypes']) or 
        (is_string($val['params']['allowed_filetypes']) and $val['params']['allowed_filetypes'] != 'any' and $val['params']['allowed_filetypes'] != $curr_type) or
        (is_array($val['params']['allowed_filetypes']) and !in_array($curr_type, $val['params']['allowed_filetypes']) and !in_array('any', $val['params']['allowed_filetypes']))) 
    {
      unset($dirs[$key]);
      if ($val['dir'] == $curr_dir) {
        $curr_dir = false;
        $spawfm->unsetCurrentDirData();
      }
    } elseif (!$curr_dir or ($curr_dir and $curr_dir_reset and !empty($val['params']['default_dir']))) {
      $curr_dir_reset = true;
      $spawfm->setCurrentDirData($val);
      $curr_dir_pos = $key;
    }
  }
}

if (!sizeof($dirs)) {
  $error_msg = $lang->m('error_no_directory_available', 'spawfm');
}

// set first directory as selected if selected directory is not valid
if ($spawfm->getCurrentDirData() === false and sizeof($dirs)) {
  $keys = array_keys($dirs);
  $curr_dir_pos = $keys[0];
  $curr_dir = $dirs[$curr_dir_pos]['dir'];
  $spawfm->setCurrentDirData($dirs[$curr_dir_pos]);
}

// process subdirectories if selected and allowed
if ($spawfm->getCurrentDirSetting('recursive') and !empty($curr_dir_subdir)) {
  // filter subdir variable for validity
  $arr = explode('/', $curr_dir_subdir);
  $str = '';
  foreach ($arr as $val) {
    if (!empty($val) and $val != '..') {
      $str .= $val.'/';
    }
  }
  $curr_dir_subdir = $str;  

  // add subdirectories to list if exist and parent dir matched
  if ($spawfm->getCurrentFsDir() and file_exists($spawfm->getCurrentFsDir().$curr_dir_subdir)) {
    $dirs_new = array();
    foreach ($dirs as $pos=>$dir) {
      $dirs_new[] = $dir;
      if ($pos == $curr_dir_pos and preg_match_all('|([^/]*)/|', $curr_dir_subdir, $subdirs)) {
        // insert all subdirectories
        $subdir_path = '';
        foreach ($subdirs[1] as $cnt=>$subdir) {
          $subdir_path .= $subdir.'/';
          $subdir_data = $dir;
          $subdir_data['dir'] = $subdir_data['dir'] . $subdir_path;
          $subdir_data['caption'] = str_repeat('&nbsp;', ($cnt+1)*2).$subdir;
          $subdir_data['value'] = $spawfm->getCurrentDir() . $config->getConfigValue('spawfm_path_separator') . $subdir_path;
          $dirs_new[] = $subdir_data;
        }        
      }
    }
    $dirs = $dirs_new;
    
    // set dir vars to subdir
    $curr_dir_data = $spawfm->getCurrentDirData();
    $curr_dir_data['dir'] = $spawfm->getCurrentDir().$curr_dir_subdir;
    $curr_dir_data['fsdir'] = $spawfm->getCurrentFsDir().$curr_dir_subdir;
    $spawfm->setCurrentDirData($curr_dir_data);
  }

}

// handle file delete
if ($del_file = SpawVars::getPostVar('delete_file') and !$spawfm->deleteFile($del_file)) {
  $error_msg = $spawfm->getError();
}

// handle file rename
if ($ren_old_name = SpawVars::getPostVar('rename_from') and 
    $ren_new_name = SpawVars::getPostVar('rename_to') and
    !$spawfm->renameFile($ren_old_name, $ren_new_name)) 
{
  $error_msg = $spawfm->getError();
}

// handle new directory creation
if ($dir_name = SpawVars::getPostVar('new_folder')) {
  if (!$spawfm->createDirectory($dir_name)) {
    $error_msg = $spawfm->getError();
  } else {
  	$onload_select = $dir_name;
  }
}

// handle file upload
if ($uplfile = SpawVars::getFilesVar('upload_file') and !empty($uplfile['size'])) {
  if (!$uplfile_name = $spawfm->uploadFile($uplfile)) {
    $error_msg = $spawfm->getError();
  } else {
  	$onload_select = $uplfile_name;
  }
}

// load current directory contents:
$files = $directories = array();
$allowed_ext = array();
if ($spawfm->getCurrentFsDir()) {
  // read files
  $files = $spawfm->getFilesList();
  if ($files === false) {
    $error_msg = $lang->m('error_reading_dir', 'spawfm');
  }
  // read directories if allowed
  if ($spawfm->getCurrentDirSetting('recursive')) {
    $directories = $spawfm->getDirectoriesList();
  }
}

?>
<style type="text/css">
#file_list {
  height: 270px;
}

#file_details {
  text-align: left;
  border: 0px solid black;
  padding: 0px 5px 5px 5px;
  width: 180px;
  font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 1em;
	color: #000000;
	overflow: hidden;
	height: 270px;
}


#details_header { 
  display: none;
}
.details_header_col {
  display: inline;
  background-color: #D4D0C8;
  color: #000000; 
  float: left;
  /*margin: 1px;
  /*padding: 2px;*/
}

#details_name { width: 33%; }
#details_size { width: 14%; }
#details_type { width: 26%; }
#details_date { width: 26%; }


.filedescr_title {
  font-weight: bold;
  font-size: 0.8em;
}
.filedescr_br {
  font-size: 0.8em;
  padding-bottom: 5px;
}
.filedescr_common {
  font-size: 0.8em;
}

.filedescr_download {
  font-size: 0.8em;
  font-weight: bold;
  padding-top: 5px;
}

.filedescr_img_preview {
  width: 175px;
  height: 150px;
  padding: 2px;
  border: 1px solid silver;
  background-color: #FFFFFF;
  margin-bottom: 5px;
  text-align:center;
	line-height:150px;
}
.img_preview {
  border: 1px;
  vertical-align: middle;
  padding: 0px;
  margin: 0px;
}

#error {
  color: #FF0000;
  font-size: 0.8em;
  font-weight: bold;
}

</style>

<script type="text/javascript" src="<?php echo $config->getConfigValue('SPAW_DIR') ?>plugins/spawfm/dialogs/spawfm.js?<?php echo time(); ?>"></script>
<script type="text/javascript">
<?php
// populate directories list
$c = 0;
foreach ($directories as $directory) {
  echo 'SpawFm.addDirectory(\''.SpawFm::escJsStr($directory['name'])."', '".
                            $directory['size']."', '".
                            date('Y-m-d H:i:s', $directory['date'])."', '".
                            SpawFm::escJsStr($directory['descr'])."', '".
                            $directory['icon']."', '".
                            $directory['icon_big']."', '".
                            $directory['thumb']."', '".
                            SpawFm::escJsStr($directory['other']).
                            "');\n";
  if (!empty($onload_select) and $directory['name'] == $onload_select) {
    $onload_select = $c;
  }
  $c++;
}

// populate files list
$c = 0;
foreach ($files as $file) {
  echo 'SpawFm.addFile(\''.SpawFm::escJsStr($file['name'])."', '".
                            $file['size']."', '".
                            date('Y-m-d H:i:s', $file['date'])."', '".
                            SpawFm::escJsStr($file['fdescr'])."', '".
                            $file['icon']."', '".
                            $file['icon_big']."', '".
                            $file['thumb']."', '".
                            SpawFm::escJsStr($file['other']).
                            "');\n";
  // check whick file was uploaded
  if (!empty($onload_select) and $file['name'] == $onload_select) {
    $onload_select = sizeof($directories) + $c;
  }
  $c++;
}
?>

SpawFm.setViewMode(1);

SpawFm.txtFileSize = '<?php echo SpawFm::escJsStr($lang->m('size', 'file_details')); ?>';
SpawFm.txtFileDate = '<?php echo SpawFm::escJsStr($lang->m('date', 'file_details')); ?>';
SpawFm.txtConfirmDelete = '<?php echo SpawFm::escJsStr($lang->m('confirm_delete', 'spawfm')); ?>';
SpawFm.txtDownload = '<?php echo SpawFm::escJsStr($lang->m('download_file', 'spawfm')); ?>';
SpawFm.txtRename = '<?php echo SpawFm::escJsStr($lang->m('rename_text', 'spawfm')); ?>';
SpawFm.txtCreateDirectory = '<?php echo SpawFm::escJsStr($lang->m('newdirectory_text', 'spawfm')); ?>';
SpawFm.txtConfirmDeleteDir = '<?php echo SpawFm::escJsStr($lang->m('confirmdeletedir_text', 'spawfm')); ?>';

SpawFm.filePath = '<?php echo addslashes($spawfm->getCurrentDir()); ?>';
SpawFm.allowModify = <?php echo $spawfm->getCurrentDirSetting('allow_modify') ? 'true' : 'false'; ?>;
SpawFm.allowModifySubdirectories = <?php echo $spawfm->getCurrentDirSetting('allow_modify_subdirectories') ? 'true' : 'false'; ?>;

<?php
// select uploaded file
if (!empty($onload_select)) {
  ?>
SpawFm.onloadSelectFile = <?php echo $onload_select; ?>;
  <?php
}
?>

</script>
<form name="spawfm_form" method="post" enctype="multipart/form-data">
<input type="hidden" name="delete_file" value="" />
<input type="hidden" name="new_folder" value="" />
<input type="hidden" name="rename_from" value="" />
<input type="hidden" name="rename_to" value="" />
<input type="hidden" name="subdir" value="<?php echo isset($curr_dir_pos) and $curr_dir_pos !== false ? $curr_dir_pos : ''; ?>" />
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr>
  <td nowrap="nowrap" colspan="2" style="border-bottom: 1px solid #000000;">
    <table border="0" cellpadding="2" cellspacing="0" width="550">
    <tr>
      <td valign="middle" nowrap="nowrap" width="350">
        <select name="dir" style="width: 350px;" onchange="document.spawfm_form.submit()">
          <?php
          foreach ($dirs as $dir) {
            $st = ($dir['dir'] == $spawfm->getCurrentDir()) ? ' selected="selected"' : '';
            $val = isset($dir['value']) ? $dir['value'] : $dir['dir'];
            $val = SpawFm::escapeHtml($val);
            echo '<option value="'.$val.'"'.$st.'>';
            echo SpawFm::escapeHtml($dir['caption']);
            echo '</option>'."\n";
          }
          ?>
        </select>
      </td>
      <td valign="middle" nowrap="nowrap">
        <?php
        if (!empty($curr_dir_subdir)) {
          echo '<input type="image" onclick="SpawFm.goUpClick();" src="../plugins/spawfm/img/btn_up.gif" title="'.$lang->m('go_up', 'buttons').'" class="bt" style="width: 24px; height: 24px; margin: 1px;" />';
        } else {
          echo '<input type="image" src="../plugins/spawfm/img/btn_up_off.gif" title="'.$lang->m('go_up', 'buttons').'" class="bt" style="width: 24px; height: 24px; margin: 1px;" disabled="disabled" />';
        }
        if (!$spawfm->getCurrentDirSetting('recursive') or 
            !$spawfm->getCurrentDirSetting('allow_create_subdirectories')) 
        {
          echo '<input type="image" src="../plugins/spawfm/img/btn_new_folder_off.gif" title="'.$lang->m('create_directory', 'buttons').'" class="bt" style="width: 24px; height: 24px; margin: 1px;" disabled="disabled" />';
        } else {
          echo '<input type="image" onclick="SpawFm.createDirectoryClick();" src="../plugins/spawfm/img/btn_new_folder.gif" title="'.$lang->m('create_directory', 'buttons').'" class="bt" style="width: 24px; height: 24px; margin: 1px;" />';
        }
        ?>
      </td>
      <td valign="middle" nowrap="nowrap" align="right">
        <?php
        if (!$type_fixed) {
        ?>
        &nbsp;
        <select name="type" style="width: 150px;" onchange="document.spawfm_form.submit()">
          <option value="*"><?php echo $lang->m('any', 'filetypes'); ?></option>
          <?php
          foreach ($all_types as $type) {
            $st = ($curr_type == $type) ? ' selected="selected"' : '';
            echo '<option value="'.SpawFm::escapeHtml($type).'"'.$st.'>';
            $title = strlen($lang->m($type, 'filetypes')) ? $lang->m($type, 'filetypes') : $type;
            if (isset($filetypes[$type])) {
              $title .= str_replace('.', '', '('.implode(', ', $filetypes[$type]).')');
            }
            echo SpawFm::escapeHtml($title);
            echo '</option>'."\n";
          }
          ?>
        </select>
        <?php
        }
        ?>
      </td>
      <td valign="middle" align="right" nowrap="nowrap">
        <!-- 
        &nbsp;
        <a href="javascript:SpawFm.applyViewMode(1);"><img src="<?php echo $imgdir; ?>btn_view_list.gif" alt="<?php echo $lang->m('view_list', 'buttons'); ?>" title="<?php echo $lang->m('view_list', 'buttons'); ?>" style="border: 0px;" /></a>
        <a href="javascript:SpawFm.applyViewMode(2);"><img src="<?php echo $imgdir; ?>btn_view_details.gif" alt="<?php echo $lang->m('view_details', 'buttons'); ?>" title="<?php echo $lang->m('view_details', 'buttons'); ?>" style="border: 0px;" /></a>
        <a href="javascript:SpawFm.applyViewMode(3);"><img src="<?php echo $imgdir; ?>btn_view_thumbs.gif" alt="<?php echo $lang->m('view_thumbs', 'buttons'); ?>" title="<?php echo $lang->m('view_thumbs', 'buttons'); ?>" style="border: 0px;" /></a>
        -->
      </td>
    </tr>
    </table>
  </td>
</tr>
<tr>
  <td nowrap="nowrap" style="border-right: 1px solid #000000; border-bottom: 1px solid #000000;" width="90%">
    <div id="file_list">
      <div id="details_header">
        <div id="details_name" class="details_header_col"><?php echo $lang->m('name', 'file_details'); ?></div>
        <div id="details_size" class="details_header_col"><?php echo $lang->m('size', 'file_details'); ?></div>
        <div id="details_type" class="details_header_col"><?php echo $lang->m('type', 'file_details'); ?></div>
        <div id="details_date" class="details_header_col"><?php echo $lang->m('date', 'file_details'); ?></div>
      </div>
      <iframe src="../empty/empty.html?<?php echo microtime(); ?>" id="dir_cont" onload="SpawFm.initIframe();" name="dir_cont" scrolling="auto" width="100%" height="100%" frameborder="0"></iframe>
    </div>
  </td>
  <td width="180" nowrap="nowrap" valign="top" style="border-bottom: 1px solid #000000;">
    <div id="file_details"></div>
  </td>
</tr>
<tr>
  <td colspan="2" nowrap="nowrap" style="border-bottom: 1px solid #000000;">
    <input type="button" name="delete_button" value="<?php echo $lang->m('delete', 'buttons')?>" class="bt" disabled="disabled" onclick="SpawFm.deleteClick()" />
    <input type="button" name="rename_button" value="<?php echo $lang->m('rename', 'buttons')?>" class="bt" disabled="disabled" onclick="SpawFm.renameClick()" />
    <?php    
    if (!is_writeable($spawfm->getCurrentFsDir()) or !$spawfm->getCurrentDirSetting('allow_upload'))
      $st = ' disabled="disabled"';
    else
      $st = '';
    ?>
    &nbsp;
    <input type="file" name="upload_file" class="input" />
    <input type="submit" name="upload_button" value="<?php echo $lang->m('upload', 'buttons')?>"<?php echo $st; ?> class="bt" />
  </td>
</tr>
<tr>
  <td align="left" valign="top" style="padding: 5px;">
    <div id="error"><?php echo $error_msg; ?></div>
  </td>
  <td align="right" valign="bottom" nowrap="nowrap" style="padding: 5px;">
    <input type="button" name="ok_button" value="<?php echo $lang->m('ok', 'buttons')?>" onClick="SpawFm.okClick()" class="bt" disabled="disabled" />
    <input type="button" name="cancel_button" value="<?php echo $lang->m('cancel', 'buttons')?>" onClick="SpawFm.cancelClick()" class="bt" />
  </td>
</tr>
</table>
</form>
