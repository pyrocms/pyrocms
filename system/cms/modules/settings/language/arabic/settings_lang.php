<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings_save_success'] 					= 'تم حفظ إعداداتك!';
$lang['settings_edit_title'] 					= 'تعديل الإعدادات';

#section settings
$lang['settings_site_name'] 					= 'إسم الموقع';
$lang['settings_site_name_desc'] 				= 'إسم الموقع المستخدم في عناوين الصفحات وفي مختلف أقسام الموقع.';

$lang['settings_site_slogan'] 					= 'شعار الموقع';
$lang['settings_site_slogan_desc'] 				= 'شعار الموقع المستخدم في عناوين الصفحات وفي مختلف أقسام الموقع.';

$lang['settings_site_lang']						= 'لغة الموقع';
$lang['settings_site_lang_desc']				= 'اللغة الأساسية للموقع والمستخدمة لاختيار قوالب البريد الإلكتروني للتنويهات الداخلية واتصالات الزوار وغيرها من المزايا التي تسهل على المستخدم التعامل مع الموقع بلغته.';

$lang['settings_contact_email'] 				= 'عنوان البريد الإلكتروني للإتصال';
$lang['settings_contact_email_desc'] 			= 'جميع الرسائل الواردة من المستخدمين، والضيوف والموقع سترسل إلى عنوان البريد الإلكتروني هذا.';

$lang['settings_server_email'] 					= 'عنوان البريد الإلكتروني للخادم';
$lang['settings_server_email_desc'] 			= 'جميع الرسائل المرسلة إلى المستخدمين ستُرسل من هذا العنوان.';

$lang['settings_meta_topic']					= 'عنوان ميتا';
$lang['settings_meta_topic_desc']				= 'كلمتان أو ثلاث تصف نوع الشركة/الموقع.';

$lang['settings_currency'] 						= 'العُملة';
$lang['settings_currency_desc'] 				= 'رمز العُملة لاستخدامه في المنتجات، والخدمات، إلخ.';

$lang['settings_dashboard_rss'] 				= 'تغذية RSS في لوحة التحكم';
$lang['settings_dashboard_rss_desc'] 			= 'رابط إلى تغذية RSS تظهر في لوحة التحكم.';

$lang['settings_dashboard_rss_count'] 			= 'عدد أخبار RSS في لوحة التحكم';
$lang['settings_dashboard_rss_count_desc'] 		= 'كم عدد أخبار RSS التي تود إظهارها في لوحة التحكم؟';

$lang['settings_date_format'] 					= 'نسق التاريخ';
$lang['settings_date_format_desc']				= 'كيف يجب عرض التواريخ في الموقع ولوحة التحكم؟ ' .
													'باستخدام <a href="http://php.net/manual/en/function.date.php" target="_black">نسق تواريخ</a> PHP - أو - ' .
													'باستخدام نسق <a href="http://php.net/manual/en/function.strftime.php" target="_black">النصوص المُنسّقة كتواريخ</a> باستخدام PHP.';

$lang['settings_frontend_enabled'] 				= 'حالة الموقع';
$lang['settings_frontend_enabled_desc'] 		= 'استخدم هذا الخيار لإتاحة أو حجب واجهة الموقع. يُمكن الإستفادة من هذا الخيار لحجب الموقع وقت الصيانة.';

$lang['settings_mail_protocol'] 				= 'بروتوكول البريد';
$lang['settings_mail_protocol_desc'] 			= 'اختر بروتوكول البريد الإلكتروني المطلوب.';

$lang['settings_mail_sendmail_path'] 			= 'مسار Sendmail';
$lang['settings_mail_sendmail_path_desc']		= 'المسار إلى برنامج sendmail.';

$lang['settings_mail_smtp_host'] 				= 'مضيف SMTP';
$lang['settings_mail_smtp_host_desc'] 			= 'اسم مضيف خادم smtp.';

$lang['settings_mail_smtp_pass'] 				= 'كلمة مرور SMTP';
$lang['settings_mail_smtp_pass_desc'] 			= 'كلمة مرور SMTP.';

$lang['settings_mail_smtp_port'] 				= 'منفذ SMTP';
$lang['settings_mail_smtp_port_desc'] 			= 'رقم منفذ SMTP.';

$lang['settings_mail_smtp_user'] 				= 'اسم مستخدم SMTP';
$lang['settings_mail_smtp_user_desc'] 			= 'اسم مستخدم SMTP.';

$lang['settings_unavailable_message']			= 'رسالة توقّف الموقع';
$lang['settings_unavailable_message_desc'] 		= 'عند إيقاف الموقع أو عندما تكون هناك مشكلة، ستظهر هذه الرسالة للمستخدمين.';

$lang['settings_default_theme'] 				= 'السمة الافتراضية';
$lang['settings_default_theme_desc'] 			= 'إختر السمة التي تريد عرضها للمستخدمين بشكل افتراضي.';

$lang['settings_activation_email'] 				= 'رسالة التفعيل';
$lang['settings_activation_email_desc'] 		= 'إرسال رسالة تفعيل عند تسجيل المستخدم مع رابط التفعيل. عطّل هذا الخيار كي تسمح للمُدراء فقط تفعيل الحسابات.';

$lang['settings_records_per_page'] 				= 'عدد السجلات في الموقع';
$lang['settings_records_per_page_desc'] 		= 'كم عدد السجلات التي يجب أن تظهر في كل صفحة في قسم الإدارة؟';

$lang['settings_rss_feed_items'] 				= 'عدد عناصر التغذية الإخبارية';
$lang['settings_rss_feed_items_desc'] 			= 'كم عنصراً تريد عرضها في تغذية RSS أو الأخبار؟';

$lang['settings_require_lastname'] 				= 'طلب إسم العائلة؟';
$lang['settings_require_lastname_desc'] 		= 'في بعض الحالات، قد لا يكون إسم العائلة مطلوباً. هل تريد إجبار المستخدمين كتابته أم لا؟';

$lang['settings_enable_profiles'] 				= 'تمكين الملفات الشخصية';
$lang['settings_enable_profiles_desc'] 			= 'تمكين المستخدمين من إضافة وتعديل ملفّاتهم الشخصيّة.';

$lang['settings_ga_email'] 						= 'البريد الإلكتروني المرتبط بخدمة إحصائيات جوجل.';
$lang['settings_ga_email_desc']					= 'عنوان البريد الإلكتروني المستخدم لخدمة إحصائيات جوجل. نحتاج لهذه المعلومة لعرض الرسم البياني في لوحة التحكم.';

$lang['settings_ga_password'] 					= 'كلمة مرور خدمة إحصائيات جوجل';
$lang['settings_ga_password_desc']				= 'كلمة مرور خدمة إحصائيات جوجل. نحتاج لهذه المعلومة أيضاً لعرض الرسم البياني في لوحة التحكم.';

$lang['settings_ga_profile'] 					= 'سجلّ خدمة إحصائيات جوجل';
$lang['settings_ga_profile_desc']				= 'مُعرّف السجل لهذا الموقع في خدمة إحصائيات جوجل.';

$lang['settings_ga_tracking'] 					= 'رمز تتبّع جوجل';
$lang['settings_ga_tracking_desc']				= 'أدخل رمز تتبع خدمة إحصائيات جوجل لتفعيل عرض بيانات الخدمة. مثال: UA-19483569-6';

$lang['settings_twitter_username'] 				= 'إسم المستخدم';
$lang['settings_twitter_username_desc'] 		= 'إسم مستخدم تويتر.';

$lang['settings_twitter_consumer_key'] 			= 'رمز المستخدم';
$lang['settings_twitter_consumer_key_desc'] 	= 'رمز مستخدم تويتر.';

$lang['settings_twitter_consumer_key_secret'] 	= 'كلمة سرّ المستفيد';
$lang['settings_twitter_consumer_key_secret_desc'] = 'كلمة سرّ مُستفيد تويتر.';

$lang['settings_twitter_blog']					= 'الدمج مع تويتر والأخبار';
$lang['settings_twitter_blog_desc'] 			= 'هل تريد نشر روابط مقالات الأخبار الجديدة على تويتر؟';

$lang['settings_twitter_feed_count'] 			= 'عدد رسائل تويتر';
$lang['settings_twitter_feed_count_desc'] 		= 'ما عدد رسائل تويتر التي يجب قراءتها في بلوك تويتر؟';

$lang['settings_twitter_cache'] 				= 'وقت الكاش';
$lang['settings_twitter_cache_desc'] 			= 'ما المدة بالدقائق التي يجب خلالها تخزين رسائل تويتر بشكل مؤقت؟';

$lang['settings_akismet_api_key'] 				= 'رمز API لخدمة أكيزمت';
$lang['settings_akismet_api_key_desc'] 			= 'خدمة أكيزمت هي خدمة منع الرسائل الغير مرغوبة أنشأها فريق وورد برس. تسيطر هذه الخدمة على المُحتوى الغير مرغوب دون الحاجة إلى استخدام الكابتشا في الاستمارات.';

$lang['settings_comment_order'] 				= 'ترتيب التعليقات';
$lang['settings_comment_order_desc']			= 'ترتيب ظهور التعليقات.';

$lang['settings_moderate_comments'] 			= 'مراقبة التعليقات';
$lang['settings_moderate_comments_desc']		= 'طلب الموافقة على التعليقات قبل ظهورها على الموقع.';

$lang['settings_version'] 						= 'النسخة';
$lang['settings_version_desc'] 					= '';

#section titles
$lang['settings_section_general']				= 'عام';
$lang['settings_section_integration']			= 'الدمج';
$lang['settings_section_comments']				= 'تعليقات';
$lang['settings_section_users']					= 'المستخدمون';
$lang['settings_section_statistics']			= 'إحصاءيات';
$lang['settings_section_twitter']				= 'تويتر';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'مفتوح';
$lang['settings_form_option_Closed']			= 'مُغلق';
$lang['settings_form_option_Enabled']			= 'مُمكّن';
$lang['settings_form_option_Disabled']			= 'مُعطّل';
$lang['settings_form_option_Required']			= 'إجباري';
$lang['settings_form_option_Optional']			= 'اختياري';
$lang['settings_form_option_Oldest First']		= 'الأقدم أولاً';
$lang['settings_form_option_Newest First']		= 'الأحدث أولاً';

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/arabic/settings_lang.php */
