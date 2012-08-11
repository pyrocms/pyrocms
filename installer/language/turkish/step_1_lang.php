<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Adım 1: Veritabanı ve Server Ayarları';
$lang['intro_text']		=	'PyroCMS bir kaç dakikada kurulabilecek kadar kolaydır, fakat bazı teknik sorular kafanızı karıştırabilir. Eğer bir soruda kafanız karışırsa hosting sağlayıcınız ile görüşebilir veya <a href="http://www.pyrocms.com/contact" target="_blank">buradan</a> bize sorabilirsiniz.';

$lang['db_settings']	=	'Veritabanı Ayarları';
$lang['db_text']		=	'PyroCMS ayarlar ve içerikleri saklamak için veritabınına ihtiyaç duyar. bu adımda yapmamız gereken ilk şey veritabanı bilgilerinin doğruluğunu test etmek. Eğer ne yapmanız gerektiğini bilmiyorsanız hosting sağlayıcınız ve/veya sunucu yöneticinizle görüşmelisiniz.';
$lang['db_missing']		=	'PHP, MySQL veritabanı fonksiyonları bulunamadı. Yükleyici bu durumda devam edemez. Lütfen hosting sağlayıcınızla görüşünüz!';



$lang['server']			=	'MySQL Host';
$lang['username']		=	'MySQL Kullanıcısı';
$lang['password']		=	'MySQL Parolası';
$lang['portnr']			=	'MySQL Portu';
$lang['server_settings']=	'Server Ayarları';
$lang['httpserver']		=	'HTTP Server';

$lang['httpserver_text']=	'PyroCMS kullanıcıya dinamik içerikleri ulaştırabilmek için HTTP Server\'a ihtiyaç duyar. Bu sayfayı görüntüleyebiliyorsanız buna zaten sahipsiniz anlamına gelir ama PyroCMS\'in tip HTTP Server üzerinde daha iyi performans vereceğini biliyoruz. Eğer bunların ne anlama geldiğini bilmiyorsanız burayı geçip, kuruluma devam ediniz.';

$lang['rewrite_fail']	=	'"(Apache with mod_rewrite)" özelliğinin sunucunuzda aktif olup olmadığı bilgisine ulaşamadık. Hosting sağlayıcınız ile görüşerek mod_rewrite özelliğini açtırabilir veya kendiniz kurabilirsiniz';
$lang['mod_rewrite']	=	'"(Apache with mod_rewrite)" özelliği sunucunuda aktif değildir. Hosting sağlayınız ile görüşüp aktifleştirebilir veya PyroCMS\'i "Apache (without mod_rewrite)" seçeneğinde kullanabilirsiniz.';
$lang['step2']			=	'Adım 2';

// messages
$lang['db_success']		=	'Başarılı! Veritabanı ayarları test edildi.';
$lang['db_failure']		=	'Hatalı! Veritabanına bağlanırken hata oluştu: ';

/* End of file step_1_lang.php */
