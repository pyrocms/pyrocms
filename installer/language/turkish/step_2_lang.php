<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Adım 2: Gereksinim Kontrolü';
$lang['intro_text']		= 	'Yükleyicinin ikinci adımı sunucunuzun PyroCMS\'i desteklediğini kontrol etmek içindir. Bir çok sunucu PyroCMS\'in çalışabilmesi için gerekli olan ayarları destekler!';

$lang['mandatory']		= 	'Zorunlu';
$lang['recommended']	= 	'Önerilen';

$lang['server_settings']= 	'HTTP Server Ayarları';
$lang['server_version']	=	'Sunucu Yazılımınız:';
$lang['server_fail']	=	'Sunucu yazılımınız desteklenmemektedir, fakat PyroCMS çalışabilir ve/veya çalışamayabilir. PyroCMS\'i sorunsuz kullanabilmek için gerekli olan PHP ve MySQL sürümleriniz güncel olmasıdır.';

$lang['php_settings']	=	'PHP Ayarları';
$lang['php_required']	=	'PyroCMS %s veya daha yüksek PHP sürümüne ihtiyaç duyar.';
$lang['php_version']	=	'Sunucunuzda olan versiyon';
$lang['php_fail']		=	'PHP versiyonunuz desteklenmemektedir. PyroCMS %s veya daha yüksek PHP sürümüne ihtiyaç duyar.';

$lang['mysql_settings']	=	'MySQL Ayarları';
$lang['mysql_required']	=	'PyroCMS veritabanınıza erişebilmek için versiyon 5.0 veya yukarısına ihtiyaç duyar.';
$lang['mysql_version1']	=	'Sunucunuzda bulunan';
$lang['mysql_version2']	=	'İstemcinizde bulunan';
$lang['mysql_fail']		=	'MySQL versiyonunuz desteklenmemektedir. PyroCMS veritabanınıza erişebilmek için versiyon 5.0 veya yukarısına ihtiyaç duyar.';

$lang['gd_settings']	=	'GD Ayarları';
$lang['gd_required']	= 	'PyroCMS, görsellerin manipülasyonları için GD library 1.0 veya yukarısına ihtiyaç duyar.';
$lang['gd_version']		= 	'Sunucunuzda bulunan';
$lang['gd_fail']		=	'GD bulunamadı, bu genellikle GD\'in kurulu olmadığına işaret eder. PyroCMS bu şekilde çalışabilir fakat bazı fonksiyonları kullanabilmek için yüklemeniz gerekmektedir.';

$lang['summary']		=	'Özet';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS tema yüklemeleriniz için Zlib\'e ihtiyaç duyar.';
$lang['zlib_fail']		=	'Zlib bulunamadı, bu genellikle Zlib\'in kurulu olmadığına işaret eder. PyroCMS bu şekilde çalışabilir fakat bazı fonksiyonları kullanabilmek için yüklemeniz gerekmektedir.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS diğer sitelerle alışveriş için Curl kütüphanesine ihtiyaç duyar.';
$lang['curl_fail']		=	'Curl bulunamadı. Bu genellikle sunucunuzda yüklü olmadığına işaret eder. PyroCMS bu şekilde çalışabilir fakat bazı fonksiyonları kullanabilmek için yüklemeniz gerekmektedir.';

$lang['summary_success']	=	'Sunucunuz PyroCMS\'i sorunsuz çalıştırabilmek için gerekli olan bütün kurulumları içeriyor. Aşağıdaki butona tıklayarak Bir sonraki adıma geçebilirsiniz';
$lang['summary_partial']	=	'Sunucunuz PyroCMS\'i sorunsuz çalıştırabilmek için bir çok kuruluma ihtiyaç duyuyor. Bu ayarlarla PyroCMS\'i çalıştırabilirsiniz, fakat thumbnail oluşturma, resimleri kroplama gibi bazı özellikleri kullanamazsınız.';
$lang['summary_failure']	=	'Sunucunuz PyroCMS\'i çalıştırabilecek özelliklere sahip değil. Lütfen hosting sağlayıcınız ile iletişime geçiniz.';
$lang['next_step']		=	'Bir sonraki adıma geçebilirsiniz';
$lang['step3']			=	'Adım 3';
$lang['retry']			=	'Tekrar deneyiniz';

// messages
$lang['step1_failure']	=	'Lütfen aşağıdaki formda gerekli olan veritabanı ayarlarını doldurunuz...';

/* End of file step_2_lang.php */