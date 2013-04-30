<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name'] 					= 'إسم الموقع';
$lang['settings:site_name_desc'] 				= 'إسم الموقع المستخدم في عناوين الصفحات وفي مختلف أقسام الموقع.';

$lang['settings:site_slogan'] 					= 'شعار الموقع';
$lang['settings:site_slogan_desc'] 				= 'شعار الموقع المستخدم في عناوين الصفحات وفي مختلف أقسام الموقع.';

$lang['settings:site_lang']						= 'لغة الموقع';
$lang['settings:site_lang_desc']				= 'اللغة الأساسية للموقع والمستخدمة لاختيار قوالب البريد الإلكتروني للتنويهات الداخلية واتصالات الزوار وغيرها من المزايا التي تسهل على المستخدم التعامل مع الموقع بلغته.';

$lang['settings:contact_email'] 				= 'عنوان البريد الإلكتروني للإتصال';
$lang['settings:contact_email_desc'] 			= 'جميع الرسائل الواردة من المستخدمين، والضيوف والموقع سترسل إلى عنوان البريد الإلكتروني هذا.';

$lang['settings:server_email'] 					= 'عنوان البريد الإلكتروني للخادم';
$lang['settings:server_email_desc'] 			= 'جميع الرسائل المرسلة إلى المستخدمين ستُرسل من هذا العنوان.';

$lang['settings:meta_topic']					= 'عنوان ميتا';
$lang['settings:meta_topic_desc']				= 'كلمتان أو ثلاث تصف نوع الشركة/الموقع.';

$lang['settings:currency'] 						= 'العُملة';
$lang['settings:currency_desc'] 				= 'رمز العُملة لاستخدامه في المنتجات، والخدمات، إلخ.';

$lang['settings:dashboard_rss'] 				= 'تغذية RSS في لوحة التحكم';
$lang['settings:dashboard_rss_desc'] 			= 'رابط إلى تغذية RSS تظهر في لوحة التحكم.';

$lang['settings:dashboard_rss_count'] 			= 'عدد أخبار RSS في لوحة التحكم';
$lang['settings:dashboard_rss_count_desc'] 		= 'كم عدد أخبار RSS التي تود إظهارها في لوحة التحكم؟';

$lang['settings:date_format'] 					= 'نسق التاريخ';
$lang['settings:date_format_desc']				= 'كيف يجب عرض التواريخ في الموقع ولوحة التحكم؟ ' .
													'باستخدام <a href="http://php.net/manual/en/function.date.php" target="_black">نسق تواريخ</a> PHP - أو - ' .
													'باستخدام نسق <a href="http://php.net/manual/en/function.strftime.php" target="_black">النصوص المُنسّقة كتواريخ</a> باستخدام PHP.';

$lang['settings:frontend_enabled'] 				= 'حالة الموقع';
$lang['settings:frontend_enabled_desc'] 		= 'استخدم هذا الخيار لإتاحة أو حجب واجهة الموقع. يُمكن الإستفادة من هذا الخيار لحجب الموقع وقت الصيانة.';

$lang['settings:mail_protocol'] 				= 'بروتوكول البريد';
$lang['settings:mail_protocol_desc'] 			= 'اختر بروتوكول البريد الإلكتروني المطلوب.';

$lang['settings:mail_sendmail_path'] 			= 'مسار Sendmail';
$lang['settings:mail_sendmail_path_desc']		= 'المسار إلى برنامج sendmail.';

$lang['settings:mail_smtp_host'] 				= 'مضيف SMTP';
$lang['settings:mail_smtp_host_desc'] 			= 'اسم مضيف خادم smtp.';

$lang['settings:mail_smtp_pass'] 				= 'كلمة مرور SMTP';
$lang['settings:mail_smtp_pass_desc'] 			= 'كلمة مرور SMTP.';

$lang['settings:mail_smtp_port'] 				= 'منفذ SMTP';
$lang['settings:mail_smtp_port_desc'] 			= 'رقم منفذ SMTP.';

$lang['settings:mail_smtp_user'] 				= 'اسم مستخدم SMTP';
$lang['settings:mail_smtp_user_desc'] 			= 'اسم مستخدم SMTP.';

$lang['settings:unavailable_message']			= 'رسالة توقّف الموقع';
$lang['settings:unavailable_message_desc'] 		= 'عند إيقاف الموقع أو عندما تكون هناك مشكلة، ستظهر هذه الرسالة للمستخدمين.';

$lang['settings:default_theme'] 				= 'السمة الافتراضية';
$lang['settings:default_theme_desc'] 			= 'إختر السمة التي تريد عرضها للمستخدمين بشكل افتراضي.';

$lang['settings:activation_email'] 				= 'رسالة التفعيل';
$lang['settings:activation_email_desc'] 		= 'إرسال رسالة تفعيل عند تسجيل المستخدم مع رابط التفعيل. عطّل هذا الخيار كي تسمح للمُدراء فقط تفعيل الحسابات.';

$lang['settings:records_per_page'] 				= 'عدد السجلات في الموقع';
$lang['settings:records_per_page_desc'] 		= 'كم عدد السجلات التي يجب أن تظهر في كل صفحة في قسم الإدارة؟';

$lang['settings:rss_feed_items'] 				= 'عدد عناصر التغذية الإخبارية';
$lang['settings:rss_feed_items_desc'] 			= 'كم عنصراً تريد عرضها في تغذية RSS أو الأخبار؟';


$lang['settings:enable_profiles'] 				= 'تمكين الملفات الشخصية';
$lang['settings:enable_profiles_desc'] 			= 'تمكين المستخدمين من إضافة وتعديل ملفّاتهم الشخصيّة.';

$lang['settings:ga_email'] 						= 'البريد الإلكتروني المرتبط بخدمة إحصائيات جوجل.';
$lang['settings:ga_email_desc']					= 'عنوان البريد الإلكتروني المستخدم لخدمة إحصائيات جوجل. نحتاج لهذه المعلومة لعرض الرسم البياني في لوحة التحكم.';

$lang['settings:ga_password'] 					= 'كلمة مرور خدمة إحصائيات جوجل';
$lang['settings:ga_password_desc']				= 'كلمة مرور خدمة إحصائيات جوجل. نحتاج لهذه المعلومة أيضاً لعرض الرسم البياني في لوحة التحكم.';

$lang['settings:ga_profile'] 					= 'سجلّ خدمة إحصائيات جوجل';
$lang['settings:ga_profile_desc']				= 'مُعرّف السجل لهذا الموقع في خدمة إحصائيات جوجل.';

$lang['settings:ga_tracking'] 					= 'رمز تتبّع جوجل';
$lang['settings:ga_tracking_desc']				= 'أدخل رمز تتبع خدمة إحصائيات جوجل لتفعيل عرض بيانات الخدمة. مثال: UA-19483569-6';

$lang['settings:akismet_api_key'] 				= 'رمز API لخدمة أكيزمت';
$lang['settings:akismet_api_key_desc'] 			= 'خدمة أكيزمت هي خدمة منع الرسائل الغير مرغوبة أنشأها فريق وورد برس. تسيطر هذه الخدمة على المُحتوى الغير مرغوب دون الحاجة إلى استخدام الكابتشا في الاستمارات.';

$lang['settings:comment_order'] 				= 'ترتيب التعليقات';
$lang['settings:comment_order_desc']			= 'ترتيب ظهور التعليقات.';

$lang['settings:moderate_comments'] 			= 'مراقبة التعليقات';
$lang['settings:moderate_comments_desc']		= 'طلب الموافقة على التعليقات قبل ظهورها على الموقع.';

$lang['settings:version'] 						= 'النسخة';
$lang['settings:version_desc'] 					= '';

$lang['settings:ckeditor_config']               = 'تهيئة CKEditor';
$lang['settings:ckeditor_config_desc']          = 'تجد قائمة بعناصر التهيئة الصحيح في موقع <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">وثائق CKEditor\'s.</a>';

$lang['settings:enable_registration']           = 'تمكين تسجيل المستخدمين';
$lang['settings:enable_registration_desc']      = 'اسمح للمستخدمين التسجيل في موقعك.';

$lang['settings:profile_visibility']            = 'عرض الملف الشخصي';
$lang['settings:profile_visibility_desc']       = 'حدد من يمكنه عرض ملفات المستخدمين الشخصية على صفحات الموقع العامة.';

$lang['settings:cdn_domain']                    = 'نطاق شبكة CDN';
$lang['settings:cdn_domain_desc']               = 'نطاقات CDN يمكنك من استضافة المحتوى الثابت على خادمات سريعة، مثل Amazon CloudFront أو MaxCDN.';

#section titles
$lang['settings:section_general']				= 'عام';
$lang['settings:section_integration']			= 'الدمج';
$lang['settings:section_comments']				= 'تعليقات';
$lang['settings:section_users']					= 'المستخدمون';
$lang['settings:section_statistics']			= 'إحصاءيات';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'مفتوح';
$lang['settings:form_option_Closed']			= 'مُغلق';
$lang['settings:form_option_Enabled']			= 'مُمكّن';
$lang['settings:form_option_Disabled']			= 'مُعطّل';
$lang['settings:form_option_Required']			= 'إجباري';
$lang['settings:form_option_Optional']			= 'اختياري';
$lang['settings:form_option_Oldest First']		= 'الأقدم أولاً';
$lang['settings:form_option_Newest First']		= 'الأحدث أولاً';
$lang['settings:form_option_profile_public']	= 'ظاهر للكل';
$lang['settings:form_option_profile_owner']		= 'ظاهر لصاحب الحساب فقط';
$lang['settings:form_option_profile_hidden']	= 'مخفي دائماً';
$lang['settings:form_option_profile_member']	= 'ظاهر لأي مستخدم مسجّل الدخول';
$lang['settings:form_option_activate_by_email']        	= 'تفعيل البريد الإلكتروني';
$lang['settings:form_option_activate_by_admin']        	= 'تفعيل الإدارة';
$lang['settings:form_option_no_activation']         	= 'بدون تفعيل';

// titles
$lang['settings:edit_title'] 					= 'تعديل الإعدادات';

// messages
$lang['settings:no_settings']					= 'ليست هناك أية إعدادات.';
$lang['settings:save_success'] 					= 'تم حفظ إعداداتك!';

/* End of file settings_lang.php */
