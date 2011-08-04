<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'步驟二：檢查安裝需求';
$lang['intro_text']		= 	'安裝程序的第一步是檢查您的伺服器是否支援 PyroCMS，大部分的伺服器都可以正確執行沒有問題。';
$lang['mandatory']		= 	'Mandatory'; #translate
$lang['recommended']	= 	'Recommended'; #translate

$lang['server_settings']= 	'HTTP 伺服器設定';
$lang['server_version']	=	'您的伺服器軟體:';
$lang['server_fail']	=	'您的伺服器軟體我們沒有支援，因此 PyroCMS 可能無法運作。只要您安裝的 PHP 與 MySQL 是最新的版本，PyroCMS 應該都可以正常運作。';

$lang['php_settings']	=	'PHP 設定';
$lang['php_required']	=	'PyroCMS 需要 PHP %s 或更新的版本。';
$lang['php_version']	=	'您伺服器目前的版本';
$lang['php_fail']		=	'您的 PHP 版本我們並沒有支援。PyroCMS 需要 PHP 版本 %s 或是更新的版本，才能夠正常運作。';

$lang['mysql_settings']	=	'MySQL 設定';
$lang['mysql_required']	=	'PyroCMS 需要存取 MySQL 資料庫版本 5.0 或更新的版本。';
$lang['mysql_version1']	=	'您的伺服器端(server)正在執行';
$lang['mysql_version2']	=	'您的客戶端(client)正在執行';
$lang['mysql_fail']		=	'您的 MySQL 版本我們沒有支援。PyroCMS 需要 MySQL 版本 5.0 或是更新的版本，才能夠正常運作。';

$lang['gd_settings']	=	'GD 設定';
$lang['gd_required']	= 	'PyroCMS 需要 GD 程式庫 1.0 或更新的版本，用做圖片的處理。';
$lang['gd_version']		= 	'您伺服器目前的版本';
$lang['gd_fail']		=	'我們無法確認您目前 GD 程式庫的版本，這通常表示此程式庫尚未安裝。PyroCMS 將仍然可以運作，但是圖片處理的相關功能就無法作用了。因此，我們強烈建議您先安裝並啟動 GD 程式庫。';

$lang['summary']		=	'總結';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS 需要 Zlib 才能對網站佈景主題(theme)進行解壓縮與安裝。';
$lang['zlib_fail']		=	'找不到 Zlib 程式庫。這通常表示此程式庫尚未安裝。PyroCMS 將仍然可以運作，但是安裝佈景主題的相關功能就無法作用了。因此，我們強烈建議您先安裝並啟動 Zlib 程式庫。';

$lang['curl']			=	'Curl'; #translate
$lang['curl_required']	=	'PyroCMS requires Curl in order to make connections to other sites.'; #translate
$lang['curl_fail']		=	'Curl can not be found. This usually means that Curl is not installed. PyroCMS will still run properly but some of the functions might not work. It is highly recommended to enable the Curl library.'; #translate


$lang['summary_green']	=	'您的伺服器符合正確執行 PyroCMS 的所有需求，請點選下方的按鈕進行下一步。';
$lang['summary_orange']	=	'您的伺服器符合 PyroCMS 的<em>大部分</em>需求，這表示 PyroCMS 將仍然可以運作，但是某些情況下會遇到問題，例如：在建立縮圖的尺寸縮放時。';
$lang['summary_red']	=	'看來似乎您的伺服器不符合執行 PyroCMS 的需求。請聯繫您的伺服器管理員或是網站空間的服務提供商，請他們協助解決。';
$lang['next_step']		=	'進行下一個步驟';
$lang['step3']			=	'步驟三';
$lang['retry']			=	'再試一次';

// messages
$lang['step1_failure']	=	'請在下方的表單中輸入資料庫設定的必要資訊。';

/* End of file step_2_lang.php */
/* Location: ./installer/language/chinese_traditional/step_2_lang.php */