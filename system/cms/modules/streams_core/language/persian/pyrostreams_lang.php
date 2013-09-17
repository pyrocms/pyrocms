<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 					= "ذخیره کردن فیلد مورد نظر با خطا همراه بود.";
$lang['streams:field_add_success']					= "فیلد ایجاد شد.";
$lang['streams:field_update_error']					= "به روز رسانی فیلد با خطا همراه بود.";
$lang['streams:field_update_success']				= "فیلد به روز سانی شد.";
$lang['streams:field_delete_error']					= "در هنگان حذف کردن فیلد خطایی رخ داد.";
$lang['streams:field_delete_success']				= "فیلد حذف شد.";
$lang['streams:view_options_update_error']				= "در هنگام به روزرسانی view options خطایی بروز کرد.";
$lang['streams:view_options_update_success']			= "view options به روزرسانی شد.";
$lang['streams:remove_field_error']				= "در هنگام پاک کردن این فیلد خطایی رخ داد.";
$lang['streams:remove_field_success']				= "فیلد پاک شد.";
$lang['streams:create_stream_error']				= "در هنگام ایجاد کردن استریم خطایی ایجاد شد.";
$lang['streams:create_stream_success']				= "استریم ایجاد شد.";
$lang['streams:stream_update_error']				= "بروزرسانی استیرم با خطا همراه بود.";
$lang['streams:stream_update_success']				= "استریم با موفقیت به روزرسانی شد.";
$lang['streams:stream_delete_error']				= "حذف کردن استریم با خطا همراه بود.";
$lang['streams:stream_delete_success']				= "استریم حذف شد";
$lang['streams:stream_field_ass_add_error']			= "اضافه کردن این فیلد به استریم با خطا همراه بود.";
$lang['streams:stream_field_ass_add_success']			= "فیلد به استریم اضافه شد.";
$lang['streams:stream_field_ass_upd_error']			= "به روز رسانی  واگذاری فیلد با خطا همراه بود.";
$lang['streams:stream_field_ass_upd_success']			= "واگذاری فیلد با موفقیت بروزرسانی شد.";
$lang['streams:delete_entry_error']					= "حذف کردن این ورودی با خطا همراه بود";
$lang['streams:delete_entry_success']				= "ورودی با موفقیت حذف شد.";
$lang['streams:new_entry_error']					= "اضافه کردن این ورودی با خطا همراه بود";
$lang['streams:new_entry_success']				= "ورودی با موفقیت اضافه شد.";
$lang['streams:edit_entry_error']					= "به روز رسانی این ورودی با خطا همراه بود";
$lang['streams:edit_entry_success']				= "ورودی مورد نظر به روز رسانی شد.";
$lang['streams:delete_summary']					= "آیا اطمینان دارد که می خواهید استریم <strong>%s</strong> را حذف کنید . این کار استریم <strong>%s %s</strong> را کلا حذف خواهد کرد.";

/* Misc Errors */

$lang['streams:no_stream_provided']				= "هیچ استریمی داده نشده است.";
$lang['streams:invalid_stream']					= "استریم غیر قابل قبول";
$lang['streams:not_valid_stream']                           	= "یک استریم قابل قبول نیست.";
$lang['streams:invalid_stream_id']					= "آی دی استریم قابل قبول نیست.";
$lang['streams:invalid_row']					= "سطر غیر قابل قبول";
$lang['streams:invalid_id']						= "آی دی غیر قابل قبول";
$lang['streams:cannot_find_assign']				= "واگذاری فیلد یافت نشد.";
$lang['streams:cannot_find_pyrostreams']				= "PyroStreams یافت نشد";
$lang['streams:table_exists']					= "جدولی با نام %s همینک وجود دارد.";
$lang['streams:no_results']					= "بدون نتیجه";
$lang['streams:no_entry']						= "ورودی یافت نشد.";
$lang['streams:invalid_search_type']				= "نوع سرج مناسبی نیست.";
$lang['streams:search_not_found']					= "جستجو یافت نشد.";

/* Validation Messages */

$lang['streams:field_slug_not_unique']				= "این نام انگلیسی برای فیلد همینک در وجود دارد.";
$lang['streams:not_mysql_safe_word']				= "فیلد %s توسط مای اسکیول رزرو شده است.";
$lang['streams:not_mysql_safe_characters']				= "فیلد %s شامل کاراکتر های غیر قابل قبولی است.";
$lang['streams:type_not_valid']					= "لطفا یک نوع-فیلد قابل قبول انتخاب کنید.";
$lang['streams:stream_slug_not_unique']				= "نام انگلیسی این استریم همینک وجود دارد.";
$lang['streams:field_unique']					= "فیلد %s باید یکتا باشد.";
$lang['streams:field_is_required']					= "فیلد %s اجباری است.";
$lang['streams:date_out_or_range']				= "تاریخی که برای %s انتخاب کرده اید در رنج قابل قبول نیست.";

/* Field Labels */

$lang['streams:label.field']					= "فیلد";
$lang['streams:label.field_required']				= "فیلد اجباری ";
$lang['streams:label.field_unique']					= "فیلد یکتا ";
$lang['streams:label.field_instructions']				= "دستورالعمل فیلد";
$lang['streams:label.make_field_title_column']			= "ستون عنوان، این فیلد باشد";
$lang['streams:label.field_name']					= "نام فیلد";
$lang['streams:label.field_slug']					= "نام انگلیسی فیلد";
$lang['streams:label.field_type']					= "نوع فیلد";
$lang['streams:id']						= "ID";
$lang['streams:created_by']					= "ایجاد شده توسط";
$lang['streams:created_date']					= "تاریخ ایجاد";
$lang['streams:updated_date']					= "تاریخ ویرایش";
$lang['streams:value']						= "مقدار";
$lang['streams:manage']						= "مدیریت";
$lang['streams:search']						= "جستجو";
$lang['streams:stream_prefix']					= "پیشوند استریم";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "بر روی فرم در هنگام ورود یا ویرایش اطلاعات نمایش داده می شود";
$lang['streams:instr.stream_full_name']				= "نام کامل استریم";
$lang['streams:instr.slug']						= "حروف کوچک انگلیسی و آندرلاین قابل قبول است.";

/* Titles */

$lang['streams:assign_field']					= "واگذاری فیلد به استریم";
$lang['streams:edit_assign']                                       = "ویرایش محولات و واگذاری های انجام شده";
$lang['streams:add_field']						= "ایجاد فیلد";
$lang['streams:edit_field']						= "ویرایش فیلد";
$lang['streams:fields']						= "فیلدها";
$lang['streams:streams']						= "استریم ها";
$lang['streams:list_fields']						= "لیست فیلدها";
$lang['streams:new_entry']					= "ورودی جدید";
$lang['streams:stream_entries']					= "ورودی های استریم";
$lang['streams:entries']						= "ورودی ها";
$lang['streams:stream_admin']					= "ادمین استریم";
$lang['streams:list_streams']					= "لیست استریم ها";
$lang['streams:sure']						= "مطمئن هستید؟";
$lang['streams:field_assignments'] 				= "نسبت داده فیلد ها به استریم";
$lang['streams:new_field_assign']					= "نسبت دادن فیلد";
$lang['streams:stream_name']					= "نام استریم";
$lang['streams:stream_slug']					= "نام انگلیسی";
$lang['streams:about']						= "درباره";
$lang['streams:total_entries']					= "تعداد کل ورودی ها";
$lang['streams:add_stream']					= "استریم جدید";
$lang['streams:edit_stream']					= "ویرایش استریم";
$lang['streams:about_stream']					= "درباره این استریم";
$lang['streams:title_column']					= "ستونِ عنوان";
$lang['streams:sort_method']					= "روش مرتب سازی";
$lang['streams:add_entry']					= "ورودی جدید";
$lang['streams:edit_entry']					= "ویرایش ورودی";
$lang['streams:view_options']					= "مشاهده تنظیمات";
$lang['streams:stream_view_options']				= "View Options های استریم";
$lang['streams:backup_table']					= "پشتیبان گیری از جدول استریم";
$lang['streams:delete_stream']					= "حذف استریم";
$lang['streams:entry']						= "ورودی";
$lang['streams:field_types']					= "نوع-فیلد ها";
$lang['streams:field_type']						= "نوع-فیلد";
$lang['streams:database_table']					= "جدول پایگاه داده";
$lang['streams:size']						= "اندازه";
$lang['streams:num_of_entries']					= "تعداد ورودی ها";
$lang['streams:num_of_fields']					= "تعداد فیلد ها";
$lang['streams:last_updated']					= "آخرین ویرایش";
$lang['streams:export_schema']					= "خروجی اسکیم";

/* Startup */

$lang['streams:start.add_one']					= "یکی اضافه کنید";
$lang['streams:start.no_fields']					= "شما هنوز هیچ فیلدی اضافه نکرده اید";
$lang['streams:start.no_assign'] 					= "به نظر میرسد هیچ فیلدی برای این استریم وجود ندارد";
$lang['streams:start.add_field_here']				= "یک فیلد ایجاد کنید";
$lang['streams:start.create_field_here']				= "یک فیلد ایجاد کنید";
$lang['streams:start.no_streams']					= "هیچ استریمی وجود ندارد";
$lang['streams:start.no_streams_yet']				= "استریمی وجود ندارد";
$lang['streams:start.adding_one']					= "در حال اضافه کردن";
$lang['streams:start.no_fields_to_add']				= "فیلدی برای اضافه کردن وجود ندارد";		
$lang['streams:start.no_fields_msg']				= "هیچ فیلدی برای اضافه کردن به این استریم وجود ندارد.";
$lang['streams:start.adding_a_field_here']				= "اضافه کردن یک فیلد";
$lang['streams:start.no_entries']					= "هیچ اطلاعاتی برای <strong>%s</strong> هنوز به عنوان ورودی ها اضافه نشده است.";
$lang['streams:no_entries']					= 'بدون ورودی';
$lang['streams:add_fields']					= "نسبت دادن فیلد ها";
$lang['streams:add_an_entry']					= "اضافه کردن یک ورودی";
$lang['streams:to_this_stream_or']					= "به این استریم یا";
$lang['streams:no_field_assign']					= "هیچ فیلدی نسبت داده نشده است";
$lang['streams:no_fields_msg_first']				= "به نظر میرسد برای این استریم هیچ فیلدی وجود ندارد";
$lang['streams:no_field_assign_msg']				= "قبل از اینکه شما بتوانید اطلاعاتی را اضافه کنید باید";
$lang['streams:add_some_fields']					= "تعداد فیلد را نسبت بدهید.";
$lang['streams:start.before_assign']				= "قبل از اینکه بتوانید تعدادی فیلد را به استریم نسبت بدهید باید";
$lang['streams:start.no_fields_to_assign']				= "به نظر می رسد برای نسبت داد هیچ فیلدی وجود ندارد. ";

/* Buttons */

$lang['streams:yes_delete']					= "بله حذف شود";
$lang['streams:no_thanks']					= "خیر";
$lang['streams:new_field']						= "فیلد جدید";
$lang['streams:edit']						= "ویرایش";
$lang['streams:delete']						= "حذف";
$lang['streams:remove']						= "حذف";
$lang['streams:reset']						= "ازنو";

/* Misc */

$lang['streams:field_singular']					= "فیلد";
$lang['streams:field_plural']					= "فیلدها";
$lang['streams:by_title_column']					= "برحست عنوانِ ستون";
$lang['streams:manual_order']                               	= "ترتیب دلخواه";
$lang['streams:stream_data_line']					= "ویرایش اطلاعات اساسی استریم";
$lang['streams:view_options_line'] 				= "ستون هایی را که باید در صفحه لیست اطلاعات مشخص باشند را انتخاب نمایید.";
$lang['streams:backup_line']					= "دانلود فایل زیپ از اطلاعات";
$lang['streams:permanent_delete_line']				= "حذف دائمی استریم و اطلاعات مربوط به آن";
$lang['streams:choose_a_field_type']				= "یک نوع-فیلد انتخاب نمایید";
$lang['streams:choose_a_field']					= "یک فیلد انتخاب نمایید";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 				= "کتابخانه ی reCaptcha شروع به کار کرد";
$lang['recaptcha_no_private_key']					= "شما API key ندارید؟";
$lang['recaptcha_no_remoteip'] 					= "به لحاظ موارد امنیست شما باید آی پی را برای reCAPTCHA بفرستید.";
$lang['recaptcha_socket_fail'] 					= "socket باز نشد.";
$lang['recaptcha_incorrect_response'] 				= "Incorrect Security Image Response";
$lang['recaptcha_field_name'] 					= "تصویر امنیتی";
$lang['recaptcha_html_error'] 					= "تصویر امنیتی بارگذاری نشد بعدا تلاش کنید";

/* Default Parameter Fields */

$lang['streams:max_length'] 					= "طول بیشینه";
$lang['streams:upload_location'] 					= "محل آپلود";
$lang['streams:default_value'] 					= "مقدار پیشفرض";

$lang['streams:menu_path']					= 'مسیر منو';
$lang['streams:about_instructions']					= 'شرحی کوتاه برای استریم شما';
$lang['streams:slug_instructions']					= 'این همان نام جدول شما در دیتابیس خواهد بود';
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.'; #translate
$lang['streams:menu_path_instructions']				= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate
/* End of file pyrostreams_lang.php */