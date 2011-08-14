<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'الخطوة الثانية: التحقق من المتطلبات';
$lang['intro_text']		= 	'أول خطوة في عملية التثبيت هي التحقق من دعم خادمك لمتطلبات PyroCMS. يفترض أن يكون ذلك متوفراً في معظم الأجهزة دون مشاكل.';
$lang['mandatory']		= 	'ضروري';
$lang['recommended']	= 	'مُستحسن';

$lang['server_settings']= 	'إعدادات خادم HTTP';
$lang['server_version']	=	'برامج خادمك:';
$lang['server_fail']	=	'برامج خادمك غير مدعومة، لذا قد لا يمكن تشغيل PyroCMS. طالما أن برامج PHP وMySQL لديك حديثة فقد يعمل PyroCMS بشكل صحيح، ولكن دون عناوين URL نظيفة.';

$lang['php_settings']	=	'إعدادات PHP';
$lang['php_required']	=	'يتطلب PyroCMS وجود النسخة %s أو أحدث.';
$lang['php_version']	=	'النسخة الموجودة على خادمك حالياً هي';
$lang['php_fail']		=	'نسخة PHP لديك غير مدعومة. يتطلب PyroCMS وجودة النسخة %s أو أحدث كي يعمل بشكل صحيح.';

$lang['mysql_settings']	=	'إعدادات MySQL';
$lang['mysql_required']	=	'يتطلب PyroCMS الوصول إلى خادم MySQL النسخة 5.0 أو أحدث.';
$lang['mysql_version1']	=	'الخادم يعمل';
$lang['mysql_version2']	=	'الواجهة تعمل';
$lang['mysql_fail']		=	'نسخة MySQL الحالية غير مدعومة. يتطلب PyroCMS النسخة 5.0 أو أحدث كي يعمل بشكل صحيح.';

$lang['gd_settings']	=	'إعدادات GD';
$lang['gd_required']	= 	'يتطلب PyroCMS وجود مكتبة GD النسخة 1.0 أو أحدث لتعديل الصّوَر.';
$lang['gd_version']		= 	'النسخة الموجودة على خادمك حالياً هي';
$lang['gd_fail']		=	'تعذر تحديد نسخة مكتبة GD. يعني ذلك أن المكتبة غير مثبّتة. مع أن PyroCMS سيعمل بشكل صحيح إلا أن بعض عمليات تعديل الصور لن تعمل. من المستحسن تثبيت مكتبة GD.';

$lang['summary']		=	'مُلخّص';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'يتطلب PyroCMS وجود Zlib كي يتمكن من استخراج وتثبيت السمات.';
$lang['zlib_fail']		=	'تعذر العثور على Zlib. يعني ذلك غالباً أن Zlib غير مُثبّت. ستتمكن من تشغيل PyroCMS لكن تثبيت السمات لن يعمل. من المستحسن تثبيت Zlib.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'يتطلب PyroCMS وجود Curl كي يستطيع الاتصال بالمواقع الأخرى.';
$lang['curl_fail']		=	'تعذر العثور على Curl. ذلك يعني أن Curl غير مثبّت. PyroCMS سيعمل بشكل صحيح إلا أن بعض العمليات لن تتم بشكل صحيح. من المستحسن تثبيت مكتبة Curl.';

$lang['summary_success']	=	'يستوفي خادمك جميع متطلبات PyroCMS. رجاءً تقدم إلى الخطوة التالية بالضغط على الزر أدناه.';
$lang['summary_partial']	=	'يستوفي خادمك <em>معظم</em> متطلبات PyroCMS. يعني ذلك أن PyroCMS يجب أن يعمل بشكل صحيح إلا أن هناك احتمالاً أن تواجه بعض المشاكل كتحجيم الصّوَر وإنشاء المُصغّرات.';
$lang['summary_failure']	=	'يبدو أن خادمك لا يستوفي متطلبات تشغيل PyroCMS. الرجاء الاتصال بمدير الخادم أو شركة الاستضافة لحل هذه المشكلة.';
$lang['next_step']		=	'تقدم إلى الخطوة التالية';
$lang['step3']			=	'الخطوة الثالثة';
$lang['retry']			=	'حاول مجدداً';

// messages
$lang['step1_failure']	=	'الرجاء إدخال جميع بيانات إعدادات قاعدة البيانات في النموذج أدناه.';

/* End of file step_2_lang.php */
/* Location: ./installer/language/arabic/step_2_lang.php */
