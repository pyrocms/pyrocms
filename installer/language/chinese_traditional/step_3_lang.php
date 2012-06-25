<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'步驟三：設定權限';
$lang['intro_text']		= 	'在 PyroCMS 開始安裝之前，請您先確認特定檔案與目錄的「可寫入」權限。這些檔案與目錄的列表如下，請確認所有其下的子目錄與檔案也都有正確的權限。';

$lang['folder_perm']	= 	'目錄權限';
$lang['folder_text']	=	'下列目錄 CHMOD 必須設定為 777（在某些情況下，設定 775 也可以）。';

$lang['file_perm']		=	'檔案權限';
$lang['file_text']		=	'下列檔案 CHMOD 必須設定為 666。設定「資料庫設定檔」的檔案權限必須在安裝 PyroCMS <em>之前</em>，這是很重要的。';

$lang['writable']		=	'可寫入';
$lang['not_writable']	=	'禁止寫入';

$lang['next_step']		=	'進行下一個步驟';
$lang['step4']			=	'步驟四';
$lang['retry']			=	'再試一次';