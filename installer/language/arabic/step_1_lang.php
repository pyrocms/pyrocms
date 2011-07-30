<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'الخطوة الأولى: تهيئة قاعدة البيانات والخادم';
$lang['intro_text']		=	'قبل أن نتمكن من التحقق من قاعدة البيانات، يجب أن نعرف مكانها وبيانات الإتصال بها.';

$lang['db_settings']	=	'إعدادات قاعدة البيانات';
$lang['db_text']		=	'كي يتمكن برنامج التثبيت من التحقق من إصدار خادم MySQL يجب عليك إدخال بيانات اسم المضيف، وإسم المستخدم وكلمة السرّ في الاستمارة أدناه. ستستخدم هذه الإعدادات عند تثبيت قاعدة البيانات.';

$lang['server']			=	'الخادم';
$lang['username']		=	'إسم المستخدم';
$lang['password']		=	'كلمة السرّ';
$lang['portnr']			=	'المنفذ';
$lang['server_settings']=	'إعدادات الخادم';
$lang['httpserver']		=	'خادم HTTP';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'الخطوة الثانية';

// messages
$lang['db_success']		=	'تم اختبار إعدادات قاعدة البيانات بنجاح.';
$lang['db_failure']		=	'حدثت مشكلة في الاتصال بقاعدة البيانات: ';
