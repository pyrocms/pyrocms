<?php
error_reporting(E_ALL);
class SpawFm
{
  var $thumbnails_enabled = false;
  var $current_dir = false;
  var $current_dir_data = false;
  var $current_type = false;
  var $image_ext = array('.gif', '.png', '.jpg', '.jpeg');
  var $error_msg = false;
  
  function SpawFm()
  {
  }
  
  
  function normalizeDir($dir, $stripslashes = false, $noleadslash = false)
  {
    if (!strlen($dir))
      return false;
    $dir = str_replace('\\', '/', $dir);
    if (!$noleadslash and !preg_match('#[a-z]+://#i', $dir))
      $dir = preg_replace('|^/*(.*)|', '/$1', $dir);
    $dir = SpawFm::addTrailingSlash($dir);
    if ($stripslashes) 
      return SpawVars::stripSlashes($dir);
    return $dir;
  }
  
  function addTrailingSlash($dir)
  {
    return preg_replace('|/*$|', '', $dir).'/';
  }
  
  
  function getFileIcon($filename)
  {
    $icons = SpawFm::getFileIconsDefinition($filename);
    return $icons['icon'];
  }
  
  function getFileIconBig($filename)
  {
    $icons = SpawFm::getFileIconsDefinition($filename);
    return $icons['icon_big'];
  }
  
  function getFileIconsDefinition($filename) 
  {
    global $config;
    static $spawfm_ftypes_icons;
    $icons = false;
    $ext = SpawFm::getFileExtension($filename);
    if (!isset($spawfm_ftypes_icons[$ext])) {
      // search for icon definition for this extension 
      $icons_def = $config->getConfigValue('PG_SPAWFM_FILETYPES_ICONS');
      foreach ($icons_def as $definition) {
        if (in_array($ext, $definition['extensions'])) {
          $icons = array(
            'icon'      => $definition['icon'],
            'icon_big'  => $definition['icon_big'],
          );
          break;
        }
      }
      
      // set default icon if definition not found
      if (!$icons) {
        $icons = $config->getConfigValue('PG_SPAWFM_FILETYPES_ICON_DEFAULT');
      }
      $spawfm_ftypes_icons[$ext] = $icons;
    } else {
      $icons = $spawfm_ftypes_icons[$ext];
    }
    return $icons;
  }
  
  function getFileThumbnail($filename)
  {
    $icons = SpawFm::getFileIconsDefinition($filename);
    return '../plugins/spawfm/img/'.$icons['icon_big'];
  }
  
  function getFileSize($file)
  {
    $fsize = @filesize($this->getCurrentFsDir().$file);
    if (!$fsize)
      $fsize = 0;
    return $fsize;
  }
   
  function getFileDate($file)
  {
    $fdate = @filemtime($this->getCurrentFsDir().$file);
    if (!$fdate)
      $fdate = 0;
    return $fdate;
  }
  
  function isImage($file)
  {
    $ext = $this->getFileExtension($file);
    if (in_array($ext, $this->image_ext)) {
      return true;
    }
    return false;
  }
  
  function isThumbailsModePossible($dir_path)
  {
    // check required system tools for image resizing
    // check if current directory is writable
    return true;
  }
  
  function getCurrentDir()
  {
    return !empty($this->current_dir_data['dir']) ? $this->current_dir_data['dir'] : false;
  }
  
  function getCurrentFsDir()
  {
    return !empty($this->current_dir_data['fsdir']) ? $this->current_dir_data['fsdir'] : false;
  }
  
  function setCurrentDirData($dir_data)
  {
    $this->current_dir_data = $dir_data;
  }
  
  function getCurrentDirData()
  {
    return $this->current_dir_data;
  }
  
  function unsetCurrentDirData()
  {
    $this->current_dir_data = false;
  }
  
  function getCurrentDirSetting($name)
  {
    $data = $this->getCurrentDirData();
    if (isset($data['params'][$name])) {
      return $data['params'][$name];
    }
    return false;
  }
  
  function setCurrentType($type)
  {
    $this->current_type = $type;
  }
  function getCurrentType()
  {
    return $this->current_type;
  }
  
  // returns allowed extensions for selected directory and type
  function getAllowedExtensions()
  {
    global $config;
    $allowed_ext = array();
    if (!$this->getCurrentDir() or !$curr_dir_data = $this->getCurrentDirData()) {
      return $allowed_ext;
    }
    
    $filetypes = $config->getConfigValue('PG_SPAWFM_FILETYPES');
    
    if ($curr_type = $this->getCurrentType()) {
      $allowed_ext = $filetypes[$curr_type];
    } elseif (!empty($curr_dir_data['params']['allowed_filetypes'])) {
      if (!is_array($curr_dir_data['params']['allowed_filetypes'])) {
        $curr_dir_data['params']['allowed_filetypes'] = array($curr_dir_data['params']['allowed_filetypes']);
      }
      if (sizeof($curr_dir_data['params']['allowed_filetypes'])) {
        foreach ($curr_dir_data['params']['allowed_filetypes'] as $ftype) {
          if (strlen($ftype) and $ftype{0} == '.') { // extension specified
            $allowed_ext[] = $ftype;
          } elseif (isset($filetypes[$ftype])) { // filetype group specified
            $allowed_ext = array_merge($allowed_ext, $filetypes[$ftype]);
          }
        }
      }
    }
    return $allowed_ext;
  }
  
  // returns list of files in current directory
  function getFilesList()
  {
    global $lang;
    $files = array();
    
    if (!$this->getCurrentFsDir()) {
      return $files;
    }

    $allowed_ext = $this->getAllowedExtensions();
    if ($dh = @opendir($this->getCurrentFsDir())) {
      while (false !== ($file = readdir($dh))) {
        if (!is_dir($this->getCurrentFsDir().$file)) {  
          $ext = SpawFm::getFileExtension($file);
          if (in_array('.*', $allowed_ext) or in_array($ext, $allowed_ext)) {
            $files[] = $file;
          }
        }
      }
      closedir($dh);
    } else {
      return false;
    }
    
    // reorder files by title
    natcasesort($files);
    
    // load files' details
    foreach ($files as $key=>$file) {
      $ext = SpawFm::getFileExtension($file);
      if (!strlen($fdescr = $lang->m($ext, 'filetypes'))) {
        $fdescr = strtoupper(substr($ext, 1)).' '.
                  $lang->m('filetype_suffix', 'file_details');
      }
      // additional info
      if ($imgsize = @getimagesize($this->getCurrentFsDir().$file)) {
        $other = $lang->m('img_dimensions', 'file_details').': '.$imgsize[0].'x'.$imgsize[1];
      } else {
        $other = '';
      }
      
      // get thumbail
      // TO DO
      
      $files[$key] = array(
        'type'      => 'F',
        'name'      => $file,
        'size'      => $this->getFileSize($file),
        'date'      => $this->getFileDate($file),
        'fdescr'    => $fdescr,
        'icon'      => '../plugins/spawfm/img/'.$this->getFileIcon($file),
        'icon_big'  => '../plugins/spawfm/img/'.$this->getFileIconBig($file),
        'thumb'     => $this->getFileThumbnail($file),
        'other'     => $other
      );
    }
    
    return $files;
  }
  
  // returns list of files in current directory
  function getDirectoriesList()
  {
    global $lang, $config;
    $directories = array();
    
    if (!$this->getCurrentFsDir()) {
      return $directories;
    }

    if ($dh = @opendir($this->getCurrentFsDir())) {
      while (false !== ($file = readdir($dh))) {
        if (is_dir($this->getCurrentFsDir().$file) and $file{0} != '.') {
          $directories[] = $file;
        }
      }
      closedir($dh);
    } else {
      return false;
    }
    
    // sort
    natcasesort($directories);
    
    // load details
    foreach ($directories as $key=>$file) {
      $directories[$key] = array(
        'name'      => $file,
        'date'      => $this->getFileDate($file),
        'size'      => $this->getFileSize($file),
        'descr'     => $lang->m('file_folder', 'file_details'),
        'icon'      => '../plugins/spawfm/img/'.$config->getConfigValueElement('PG_SPAWFM_FILETYPES_ICON_FOLDER', 'icon'),
        'icon_big'  => '../plugins/spawfm/img/'.$config->getConfigValueElement('PG_SPAWFM_FILETYPES_ICON_FOLDER', 'icon_big'),
        'thumb'     => $this->getFileThumbnail($file),
        'other'     => ''
      );
    }
    
    return $directories;
  }
  
  function setThumbnailsEnabled($status = false)
  {
    $this->thumbnails_enabled = $status;
  }
  
  function getThumbnailsEnabled()
  {
    return $this->thumbnails_enabled;
  }
  
  // static helper methods
  function getFileExtension($filename)
  {
    return strtolower(strrchr($filename, '.'));
  }
  
  // adds slashes before single quotes
  function escJsStr($str)
  {
    return addcslashes($str, '\'');
  }
  
  // strip leading slash
  function stripLeadSlash($dir)
  {
    if (strlen($dir) and ($dir{0} == '/' or $dir{0} == '\\')) {
      return substr($dir, 1);
    }
    return $dir;
  }
  
  // escape HTML special chars
  function escapeHtml($str)
  {
    return str_replace(
      array('<', '>', '"'), 
      array('&lt;', '&gt;', '&quot;'), 
      $str
    );
  }
  
  function error()
  {
    return false !== $this->getError();
  }
  
  function getError()
  {
    return $this->error_msg;
  }
  
  function setError($msg)
  {
    $this->error_msg = $msg;
  }
  
  function deleteFile($del_file)
  {
    global $lang;
  
    // filter file/dir name
    $del_file = basename($del_file);
    
    if (file_exists($this->getCurrentFsDir().$del_file)) {
      if (is_dir($this->getCurrentFsDir().$del_file)) {
        if (!$this->getCurrentDirSetting('recursive') or
            !$this->getCurrentDirSetting('allow_modify_subdirectories')) 
        {
          $this->setError($lang->m('error_delete_subdirectories_forbidden', 'spawfm'));
        } else {
          // check if directory is empty
          $empty = true;
          if ($dh = opendir($this->getCurrentFsDir().$del_file)) {
            while (($file = readdir($dh)) !== false) {
              if ($file != '.' and $file != '..') {
                $empty = false;
                break;
              }
            }
            closedir($dh);
          }
        
          if (!$empty) {
            $this->setError($lang->m('error_delete_subdirectories_not_empty', 'spawfm'));
          } elseif (!@rmdir($this->getCurrentFsDir().$del_file)) {
            $this->setError($lang->m('error_delete_subdirectories_failed', 'spawfm'));
          }
        }
      } else {
        if (!$this->getCurrentDirSetting('allow_modify')) {
          $this->setError($lang->m('error_delete_forbidden', 'spawfm'));
        } elseif (!@unlink($this->getCurrentFsDir().$del_file)) {
          $this->setError($lang->m('error_delete_failed', 'spawfm'));
        }
      }
    }
    
    return !$this->error();
  }
  
  function renameFile($ren_old_name, $ren_new_name)
  {
    global $lang;
    
    // cleanup/filter file/directory names
    $ren_old_name = basename($ren_old_name);
    $ren_new_name = basename(trim($ren_new_name));
    
    // check if file/directory can be renamed
    if (!file_exists($this->getCurrentFsDir().$ren_old_name)) {
      $this->setError($lang->m('error_rename_file_missing', 'spawfm'));
    } elseif (is_dir($this->getCurrentFsDir().$ren_old_name) and 
              !$this->getCurrentDirSetting('allow_modify_subdirectories')) 
    {
      $this->setError($lang->m('error_rename_directories_forbidden', 'spawfm'));
    } elseif (!is_dir($this->getCurrentFsDir().$ren_old_name) and 
              !$this->getCurrentDirSetting('allow_modify')) 
    {
      $this->setError($lang->m('error_rename_forbidden', 'spawfm'));
    } elseif (file_exists($this->getCurrentFsDir().$ren_new_name)) {
      $this->setError(str_replace('[*FILE*]', $ren_new_name, $lang->m('error_rename_file_exists', 'spawfm')));
    } else {
      // check if filetype doesn't change
      if ($this->getFileExtension($ren_old_name) != $this->getFileExtension($ren_new_name)) {
        $this->setError($lang->m('error_rename_extension_changed', 'spawfm'));
      // check if new file name is secure (for files only)
      } elseif (!is_dir($this->getCurrentFsDir().$ren_old_name) and !$this->isSecureFile($ren_new_name)) {
        $this->setError($lang->m('error_bad_filetype', 'spawfm'));
      } elseif (!@rename($this->getCurrentFsDir().$ren_old_name, $this->getCurrentFsDir().$ren_new_name)) {
        $this->setError($lang->m('error_rename_failed', 'spawfm'));
      }
    }
    
    return !$this->error();
  }
  
  function createDirectory($dir_name)
  {
    global $lang;
  
    if ($this->getCurrentDirSetting('recursive') and 
        $this->getCurrentDirSetting('allow_create_subdirectories'))
    {
      // filter dir name
      $dir_name = trim(basename($dir_name));
      
      if (preg_match('#[:<>|?*"/\\\\]+#', $dir_name)) {
        $this->setError($lang->m('error_create_directories_name_invalid', 'spawfm'));
      }
      // check if name is not used already
      elseif (file_exists($this->getCurrentFsDir().$dir_name)) {
        $this->setError($lang->m('error_create_directories_name_used', 'spawfm'));
      } else {
        // chmod created directory if specified
        if (strlen($this->getCurrentDirSetting('chmod_to'))) {
          $res = @mkdir($this->getCurrentFsDir().$dir_name, $this->getCurrentDirSetting('chmod_to'));
        } else {
          $res = @mkdir($this->getCurrentFsDir().$dir_name);
        }
        if (!$res) {
          $this->setError($lang->m('error_create_directories_failed', 'spawfm'));
        }
      }    
    } else {
      $this->setError($lang->m('error_create_directories_forbidden', 'spawfm'));
    }
    
    return !$this->error();
  }
  
  function uploadFile($uplfile)
  {
    global $lang;
  
    // check if upload is allowed
    if (!$this->getCurrentDirSetting('allow_upload')) {
      $this->setError($lang->m('error_upload_forbidden', 'spawfm'));
    } else {
      if (is_uploaded_file($uplfile['tmp_name'])) {
        // check filetype
        $ext = SpawFm::getFileExtension($uplfile['name']);
        $allowed_ext = $this->getAllowedExtensions();
        if ((in_array('.*', $allowed_ext) or in_array($ext, $allowed_ext)) and $this->isSecureFile($uplfile['name'])) {
          // check filesize
          if (!$this->getCurrentDirSetting('max_upload_filesize') or 
              $uplfile['size'] <= $this->getCurrentDirSetting('max_upload_filesize'))
          {
            $ok = true;
            $err = array();
            /*
              check image dimensions: try to read image dimensions (this step is 
              omitted if getimagesize() does not recognize file as image or fails 
              to read it's dimensions
            */
            if (($this->getCurrentDirSetting('max_img_width') or
                $this->getCurrentDirSetting('max_img_height')) and 
                $imgsize = @getimagesize($uplfile['tmp_name'])) 
            {
              // check if dimensions not too big if specified   
              if ($this->getCurrentDirSetting('max_img_width') and 
                  $imgsize[0] > $this->getCurrentDirSetting('max_img_width')) 
              {
                $ok = false;
                $err[] = str_replace('[*MAXWIDTH*]', $this->getCurrentDirSetting('max_img_width'), $lang->m('error_img_width_max', 'spawfm'));
              }
              if ($this->getCurrentDirSetting('max_img_height') and 
                  $imgsize[1] > $this->getCurrentDirSetting('max_img_height')) 
              {
                $ok = false;
                $err[] = str_replace('[*MAXHEIGHT*]', $this->getCurrentDirSetting('max_img_height'), $lang->m('error_img_height_max', 'spawfm'));
              }
            }
            if (!$ok) {
              $this->setError(implode('<br />', $err));
            } else {
              // proceed saving uploaded file
              $uplfile_name = $uplfile['name'];
              $i = 1;
              // pick unused file name
              while (file_exists($this->getCurrentFsDir().$uplfile_name)) {
                $uplfile_name = ereg_replace('(.*)(\.[a-zA-Z]+)$', '\1_'.$i.'\2', $uplfile['name']);
                $i++;
              }
              if (!@move_uploaded_file($uplfile['tmp_name'], $this->getCurrentFsDir().$uplfile_name)) {
                $this->setError($lang->m('error_upload_failed', 'spawfm'));
              } else {
                if (strlen($this->getCurrentDirSetting('chmod_to'))) {
                  // chmod uploaded file
                  if (!@chmod($this->getCurrentFsDir().$uplfile_name, $this->getCurrentDirSetting('chmod_to'))) {
                    $this->setError($lang->m('error_chmod_uploaded_file', 'spawfm'));
                  }
                }
              }
            }
          } else {
            $this->setError($lang->m('error_max_filesize', 'spawfm').' '.round($this->getCurrentDirSetting('max_upload_filesize') / 1024, 2).' KB');
          }
        } else {
          $this->setError($lang->m('error_bad_filetype', 'spawfm'));
        }
      } else {
        if ($uplfile['error'] == 1 or $uplfile['error'] == 2) {
          $this->setError($lang->m('error_upload_file_too_big', 'spawfm'));
        } elseif ($uplfile['error'] == 3) {
          $this->setError($lang->m('error_upload_file_incomplete', 'spawfm'));
        } else {
          $this->setError($lang->m('error_upload_failed', 'spawfm'));
        }
      }    
    }
    
    return $this->error() ? false : $uplfile_name;
  }
  
  function isSecureFile($filename)
  {
    $unsafe_ext = $this->getCurrentDirSetting('forbid_extensions');
    if (!empty($unsafe_ext)) {
      $filename = strtolower($filename);
      $arr = explode('.', $filename);
      foreach ($unsafe_ext as $ext) {
        $ext = strtolower($ext);
        if (($this->getCurrentDirSetting('forbid_extensions_strict') and in_array($ext, $arr)) or
            $ext == $arr[sizeof($arr)-1])
        {
          return false;
        }
      }
    }
    return true;
  }
}
?>