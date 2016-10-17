<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'步骤一：设定数据库与服务器';
$lang['intro_text']		=	'在开始检查数据库之前，我們需要知道它的所在位置以及登入的账号。';

$lang['db_settings']	=	'数据库設定';
$lang['db_text']		=	'为了让安裝程式能够检验您的 MySQL 个人版本，需要您輸入下列資料，这些资料稍后也会用來安裝数据库。';
$lang['db_missing']		=	'不能找到Mysql数据库的PHP驱动，安装程序将不能继续进行。请联系您的系统管理员按照本系统。'; // 'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate

$lang['server']			=	'MySQL 服务器';
$lang['username']		=	'账号';
$lang['password']		=	'密码';
$lang['portnr']			=	'连接端口(Port)';
$lang['server_settings']=	'服务器设定';
$lang['httpserver']		=	'HTTP 服务器';
$lang['httpserver_text']=	'PyroCMS需要一個 HTTP 服务器來显示动态內容，既然您已经看到这个页面，表示您已经有该功能了。但如果更明确的知道是哪一种服务器，那么PyroCMS將可以自行做最恰当的设定。如果您完全不了解这个設定，那就请忽略它，并继续进行安装。';
$lang['rewrite_fail']	=	'您选择了「Apache with mod_rewrite」，但我們无法分辨服务器上是否已经启用了mod_rewrite。请询问您的主机管理员，向他确认是否已经启用 mod_rewrite，或继续安裝但需自行承担风险。';
$lang['mod_rewrite']	=	'您选择了「Apache with mod_rewrite」，但您的服务器并沒有启用 mod_rewrite。请询问您的主机管理员，请他安装开启 mod_rewrite，或使用「Apache without mod_rewrite」选项來进行 PyroCMS 的安裝。';
$lang['step2']			=	'步骤 2';

// messages
$lang['db_success']		=	'数据库设定测试成功并可正常运行。';
$lang['db_failure']		=	'连接数据库时发生的问题: ';
