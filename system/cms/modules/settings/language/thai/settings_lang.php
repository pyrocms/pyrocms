<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Thai translation.
*
* @author	Nateetorn Lertkhonsan <nateetorn.l@gmail.com>
* @package	PyroCMS  
* @link		http://pyrocms.com
* @date		2012-04-19
* @version	1.0.0
**/

#section settings
$lang['settings_site_name']						= 'ชื่อเว็บไซต์';
$lang['settings_site_name_desc']				= 'ชื่อของเว็บไซต์สำหรับหน้าเพจและการใช้งานอื่นๆในเว็บไซต์';

$lang['settings_site_slogan']					= 'คำขวัญเว็บไซต์';
$lang['settings_site_slogan_desc']				= 'คำขวัญเว็บไซต์สำหรับหน้าเพจและการใช้งานอื่นๆในเว็บไซต์';

$lang['settings_site_lang']						= 'ภาษาเว็บไซต์';
$lang['settings_site_lang_desc']				= 'ภาษาของเว็บไซต์ที่ใช้ การการเลือกจะรวมไปถึงแม่แบบของการแจ้งเตือนอีเมล แบบฟอร์มการติดต่อและคุณสมบัติอื่น ๆ ';

$lang['settings_contact_email']					= 'อีเมลสำหรับการติดต่อ';
$lang['settings_contact_email_desc']			= 'ทั้งหมดอีเมลจากผู้ใช้ ผู้เยี่ยมชมที่เข้าเว็บไซต์นี้จะส่งไปที่ e-mail นี้';

$lang['settings_server_email']					= 'อีเมลสำหรับเซิร์ฟเวอร์';
$lang['settings_server_email_desc']				= 'อีเมลทั้งหมดที่จะส่งไปาหาผู้ใช้งานจะถูกส่งมาจากอีเมลนี้';

$lang['settings_meta_topic']					= 'Meta Topic';
$lang['settings_meta_topic_desc']				= 'อธิบายสองหรือสามคำเกี่ยวกับบริษัทหรือเว็บไซต์นี้';

$lang['settings_currency']						= 'สกุลเงิน';
$lang['settings_currency_desc']					= 'สัญลักษณ์สกุลเงินสำหรับการใช้งานเกี่ยวกับสินค้าบริการและอื่น ๆ';

$lang['settings_dashboard_rss']					= 'แผงควบคุม RSS Feed';
$lang['settings_dashboard_rss_desc']			= 'เชื่อมโยงไปยัง RSS Feed ที่จะแสดงบนแผงควบคุม';

$lang['settings_dashboard_rss_count']			= 'แผงควบคุม RSS Items';
$lang['settings_dashboard_rss_count_desc']		= 'คุณต้องการจะแสดงจำนวน RSS บนแผงควบคุมจำนวนเท่าไหร่ ?';

$lang['settings_date_format']					= 'รูปแบบวันที่';
$lang['settings_date_format_desc']				= 'คุณต้องการจะแสดงรูปแบบวันที่บนเว็บไซต์และเมนูควบคุมอย่างไร? ลองใช้ <a target="_blank" href="http://php.net/manual/en/function.date.php">รูปแบบวันที่</a> จาก PHP - หรือ - ใช้รูปแบบวันที่จาก <a target="_blank" href="http://php.net/manual/en/function.strftime.php">การแปลงข้อความเป็นวันที่</a> จาก PHP.';

$lang['settings_frontend_enabled']				= 'สถานะเว็บไซต์';
$lang['settings_frontend_enabled_desc']			= 'ตัวเลือกนี้เป็นส่วนที่ใช้เปิด-ปิดเว็บไซต์ จะมีประโยชน์เมื่อคุณต้องการที่จะใช้การบำรุงรักษาสำหรับเว็บไซต์';

$lang['settings_mail_protocol']					= 'อีเมล Protocol';
$lang['settings_mail_protocol_desc']			= 'ลือกโปรโตคอลอีเมลที่ต้องการ';

$lang['settings_mail_sendmail_path']			= 'Sendmail Path';
$lang['settings_mail_sendmail_path_desc']		= 'ที่อยู่สำหรับไลบราีี่ในการส่งอีเมล.';

$lang['settings_mail_smtp_host']				= 'SMTP Host';
$lang['settings_mail_smtp_host_desc']			= 'ชื่อโฮสต์ของเซิร์ฟเวอร์ของคุณ.';

$lang['settings_mail_smtp_pass']				= 'SMTP password';
$lang['settings_mail_smtp_pass_desc']			= 'รหัสผ่านของ SMTP';

$lang['settings_mail_smtp_port'] 				= 'SMTP Port';
$lang['settings_mail_smtp_port_desc'] 			= 'หมายเลขพอร์ตของ SMTP';

$lang['settings_mail_smtp_user'] 				= 'SMTP User Name';
$lang['settings_mail_smtp_user_desc'] 			= 'บัญชีผู้ใช้ของ SMTP';

$lang['settings_unavailable_message']			= 'ข้อความแสดงปัญหา';
$lang['settings_unavailable_message_desc']		= 'เมื่อเว็บไซต์ปิดการทำงานอยู่หรือมีปัญหาใหญ่ๆ ข้อความนี้จะถูกแสดงให้ผู้ใช้เห็น';

$lang['settings_default_theme']					= 'ธีมพื้นฐาน';
$lang['settings_default_theme_desc']			= 'เลือกที่คุณจะให้แสดงเป็นพื้นฐาน';

$lang['settings_activation_email']				= 'ยืนยันการใช้อีเมล';
$lang['settings_activation_email_desc']			= 'ส่งอีเมลให้ผู้ใช้งานยืนยันหลังจากสมัครสมาชิกแล้ว. ปิดการใช้งานเพื่อจะยืนยันโดยผู้ดแลระบบเท่านั้น';

$lang['settings_records_per_page']				= 'จำนวนแถวต่อหน้า';
$lang['settings_records_per_page_desc']			= 'จะแสดงจำนวนแถวต่อหน้าให้เมนูผู้ดูแลระบบจำนวนเท่าไหร่?';

$lang['settings_rss_feed_items']				= 'นับจำนวน Feed item';
$lang['settings_rss_feed_items_desc']			= 'ต้องการจะแสดง RSS/blog เป็นจำนวนเท่าไหร่?';

$lang['settings_require_lastname']				= 'ต้องการนามสุกล?';
$lang['settings_require_lastname_desc']			= 'สำหรับบางสถานการณ์นามสกุลอาจไม่จำเป็น คุณต้องการที่จะบังคับให้ผู้ใช้ป้อนด้วยหรือไม่?';

$lang['settings_enable_profiles']				= 'เปิดใช้งานโปรไฟล์';
$lang['settings_enable_profiles_desc']			= 'อนุญาตให้ผู้ใช้เพิ่มและแก้ไขโปรไฟล์ได้';

$lang['settings_ga_email']						= 'อีเมลของ Google Analytic';
$lang['settings_ga_email_desc']					= 'อีเมลของ Google Analytics, ต้องป้อนอีเมลเข้าไปด้วยหากต้องการให้แสดงในแผงควบคุม';

$lang['settings_ga_password']					= 'รหัสผ่านของ Google Analytic';
$lang['settings_ga_password_desc']				= 'รหัสผ่านของ Google Analytics, ต้องป้อนรหัสผ่านเข้าไปด้วยหากต้องการให้แสดงในแผงควบคุม';

$lang['settings_ga_profile']					= 'โปรไฟล์ของ Google Analytic';
$lang['settings_ga_profile_desc']				= 'Profile IDสำหรับเว็บไซต์นี้ใน Google Analytic';

$lang['settings_ga_tracking']					= 'Google Tracking Code';
$lang['settings_ga_tracking_desc']				= 'ป้อน Google Analytic Tracking Code ของคุณเพื่อปิดใช้งานการดึงข้อมูล เช่น: UA-19483569-6';

$lang['settings_twitter_username']				= 'ชื่อบัญชี';
$lang['settings_twitter_username_desc']			= 'ชื่อบัญชีของ Twitter';

$lang['settings_twitter_feed_count']			= 'Feed Count';
$lang['settings_twitter_feed_count_desc']		= 'ต้องการแสดงจำนวน Twitter เป็นจำนวนเท่าไหร่?';

$lang['settings_twitter_cache']					= 'เวลาของแคช';
$lang['settings_twitter_cache_desc']			= 'ต้องการเก็บ Tweets เป็นระบเวลาเท่าไหร่';

$lang['settings_akismet_api_key']				= 'Akismet API Key';
$lang['settings_akismet_api_key_desc']			= 'Akismet คือตามป้องกันสแปมจากผู้พัฒนา WordPress. มันช่วยควบคุมสแปมโดยไม่ต้องบัคับผู้ใช้งานกรอกฟอร์ม CAPTCHA';

$lang['settings_comment_order']					= 'เรียงลำดับความเห็น';
$lang['settings_comment_order_desc']			= 'เลือกการแสดงความเห็นว่าจะเรียงลำดับแบบไหน';

$lang['settings_enable_comments'] 				= 'เปิดแสดงความเห็น';
$lang['settings_enable_comments_desc']			= 'ต้องการเปิดใช้งานหรือไม่?';
	
$lang['settings_moderate_comments']				= 'อนุมัติความเห็น';
$lang['settings_moderate_comments_desc']		= 'บังคับให้ความคิดเห็นต้องได้รับอนุญาตก่อนแสดงขึ้นบนเว็บ';

$lang['settings_comment_markdown']				= 'เปิดใช้ Markdown';
$lang['settings_comment_markdown_desc']			= 'ต้องการเปิดให้ผู้เยี่ยมชมใช้งาน  Markdown ในการแสดงความเห็นหรือไม่?';

$lang['settings_version']						= 'รุ่น';
$lang['settings_version_desc']					= 'รุ่น';

$lang['settings_site_public_lang']				= 'ภาษาที่แสดง';
$lang['settings_site_public_lang_desc']			= 'คุณต้องการแสดงภาษาใดในหน้าเว็บของคุณ?';

$lang['settings_admin_force_https']				= 'บังคับใช้ HTTPS ในการใช้งานแผงควบคุม?';
$lang['settings_admin_force_https_desc']		= 'เปิดใช้งานเฉพาะโปรโตคอล HTTPS protocol เมื่อใช้งานแผงควบคุมหรือไม่?';

$lang['settings_files_cache']					= 'ไฟล์แคช';
$lang['settings_files_cache_desc']				= 'เมื่อมีการเรียกรูปภาพผ่านทางเว็บไซต์ ต้องการตั้งเวลาหมดอายุหรือไม่?';

$lang['settings_auto_username']					= 'ผู้ใช้อัตโนมัติ';
$lang['settings_auto_username_desc']			= 'เป็นสร้างผู้ใช้อัตโนมัติ หมายความว่าผู้ใช้งานสามารถข้ามขั้นตอนการลงทะเบียนได้';

$lang['settings_registered_email']				= 'เตือนเมื่อสมัครสมาชิก';
$lang['settings_registered_email_desc']			= 'ส่งอีเมลเตือนเมื่อมีคนสมัครสมาชิก';

$lang['settings_ckeditor_config']               = 'ตั้งค่า CKEditor';
$lang['settings_ckeditor_config_desc']          = 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation</a>.';

$lang['settings_enable_registration']           = 'เปิดสมัครสมาชิกEnable user registration';
$lang['settings_enable_registration_desc']      = 'เปิดให้ผู้ใช้งานสมัครสมาชิกบนเว็บไซต์ของคุณ.';

$lang['settings_cdn_domain']                    = 'CDN Domain';
$lang['settings_cdn_domain_desc']               = 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.';

# section titles
$lang['settings_section_general']				= 'ทั่วไป';
$lang['settings_section_integration']			= 'ผสานระบบ';
$lang['settings_section_comments']				= 'ความเห็น';
$lang['settings_section_users']					= 'ผู้ใช้งาน';
$lang['settings_section_statistics']			= 'สถิติ';
$lang['settings_section_twitter']				= 'Twitter';
$lang['settings_section_files']					= 'ไฟล์';

# checkbox and radio options
$lang['settings_form_option_Open']				= 'เปิด';
$lang['settings_form_option_Closed']			= 'ปิด';
$lang['settings_form_option_Enabled']			= 'เปิดใช้งาน';
$lang['settings_form_option_Disabled']			= 'ปิดใช้งาน';
$lang['settings_form_option_Required']			= 'ต้องการ';
$lang['settings_form_option_Optional']			= 'ตัวเลือกเสริม';
$lang['settings_form_option_Oldest First']		= 'เก่าขึ้นก่อน';
$lang['settings_form_option_Newest First']		= 'ใหม่ขึ้นก่อน';
$lang['settings_form_option_Text Only']			= 'เฉพาะข้อความ';
$lang['settings_form_option_Allow Markdown']	= 'เปิดใช้ Markdown';
$lang['settings_form_option_Yes']				= 'ใช่';
$lang['settings_form_option_No']				= 'ไม่';

// messages
$lang['settings_no_settings']					= 'ไม่มีการตั้งค่าขณะนี้';
$lang['settings_save_success']					= 'การตั้งค่าถูกบันทึก!';

/* End of file settings_lang.php */