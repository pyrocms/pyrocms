<?php
// global filetypes definitions
// warning: changing default filetypes may lead to unexpected behaviour 
SpawConfig::setStaticConfigItem(
  'PG_SPAWFM_FILETYPES',
  array(
    // default filetypes
    'any'           => array('.*'),
    'images'        => array('.jpg', '.gif', '.png'),
    'flash'         => array('.swf'),
    'documents'     => array('.doc', '.xls', '.pdf', '.rtf', '.odt', '.ods', '.txt'),
    'audio'         => array('.wav', '.mp3', '.ogg', '.wma'),
    'video'         => array('.avi', '.mpg', '.mpeg', '.mov', '.wmv'),
    'archives'      => array('.zip', '.rar', '.gz'),
    // add your custom filetypes below
    //'' => '',
  ), 
  SPAW_CFG_TRANSFER_SECURE
);

// filetypes icons:
// default icons
SpawConfig::setStaticConfigItem(
  'PG_SPAWFM_FILETYPES_ICON_DEFAULT',
  array(
    'icon'      => 'ico_default.gif',
    'icon_big'  => 'ico_default_big.gif',
  )
);
// icons for folders
SpawConfig::setStaticConfigItem(
  'PG_SPAWFM_FILETYPES_ICON_FOLDER',
  array(
    'icon'      => 'ico_folder.gif',
    'icon_big'  => 'ico_folder_big.gif',
  )
);  

// icons for specific filetypes (determined by their extensions)
SpawConfig::setStaticConfigItem(
  'PG_SPAWFM_FILETYPES_ICONS',
  array(
    array(
      'extensions'  => array('.jpg', '.gif', '.png'),
      'icon'        => 'ico_image.gif',
      'icon_big'    => 'ico_image_big.gif',
    ),
    array(
      'extensions'  => array('.swf'),
      'icon'        => 'ico_flash.gif',
      'icon_big'    => 'ico_flash_big.gif',
    ),
    /*
    array(
      'extensions'  => array('.doc', '.xls', '.pdf', '.rtf', '.odt', '.ods', '.txt'),
      'icon'        => 'ico_document.gif',
      'icon_big'    => 'ico_document_big.gif',
    ),
    */
  )
);

// character to separate base dir path and subdir (should be unused in filesystem names)
SpawConfig::setStaticConfigItem(
  'spawfm_path_separator',
  '|',
  SPAW_CFG_TRANSFER_JS
);
?>