<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'步驟一：設定資料庫與伺服器';
$lang['intro_text']		=	'在開始檢查資料庫之前，我們需要知道它的所在位置以及登入的帳號資訊。';

$lang['db_settings']	=	'資料庫設定';
$lang['db_text']		=	'為了讓安裝程式能夠檢查您的 MySQL 伺服器版本，需要您輸入下列資料，這些資料稍後也會用來安裝資料庫。';

$lang['server']			=	'MySQL 伺服器';
$lang['username']		=	'帳號';
$lang['password']		=	'密碼';
$lang['portnr']			=	'連接埠(Port)';
$lang['server_settings']=	'伺服器設定';
$lang['httpserver']		=	'HTTP 伺服器';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'步驟 2';

// messages
$lang['db_success']		=	'資料庫設定測試成功並可正常運作。';
$lang['db_failure']		=	'連結資料庫時發生的問題: ';
