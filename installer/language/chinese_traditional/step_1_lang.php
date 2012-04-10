<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'步驟一：設定資料庫與伺服器';
$lang['intro_text']		=	'在開始檢查資料庫之前，我們需要知道它的所在位置以及登入的帳號資訊。';

$lang['db_settings']	=	'資料庫設定';
$lang['db_text']		=	'為了讓安裝程式能夠檢查您的 MySQL 伺服器版本，需要您輸入下列資料，這些資料稍後也會用來安裝資料庫。';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate

$lang['server']			=	'MySQL 伺服器';
$lang['username']		=	'帳號';
$lang['password']		=	'密碼';
$lang['portnr']			=	'連接埠(Port)';
$lang['server_settings']=	'伺服器設定';
$lang['httpserver']		=	'HTTP 伺服器';
$lang['httpserver_text']=	'PyroCMS需要一個 HTTP 伺服器來顯示動態內容，既然您已經看到這個頁面，代表已經有了。但如果更明確的知道是哪一種伺服器，那麼 PyroCMS將可以自行做最恰當的設定。如果您完全不了解這個設定，那就請忽略它，並繼續進行安裝。';
$lang['rewrite_fail']	=	'您選擇了「Apache with mod_rewrite」，但我們無法分辨伺服器上已經啟用了mod_rewrite。請詢問您的主機管理員，向他確認是否已經啟用 mod_rewrite，或繼續安裝但需自行承擔風險。';
$lang['mod_rewrite']	=	'您選擇了「Apache with mod_rewrite」，但您的伺服器並沒有啟用 mod_rewrite。請詢問您的主機管理員，請他安裝開啟 mod_rewrite，或使用「Apache without mod_rewrite」選項來進行 PyroCMS 的安裝。';
$lang['step2']			=	'步驟 2';

// messages
$lang['db_success']		=	'資料庫設定測試成功並可正常運作。';
$lang['db_failure']		=	'連結資料庫時發生的問題: ';
