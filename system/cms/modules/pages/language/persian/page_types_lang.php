<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'اطلاعات پایه ای';

// labels
$lang['page_types:updated_label']              = 'آپدیت شده';
$lang['page_types:layout']                     = 'صفحه بندی';
$lang['page_types:auto_create_stream']         = 'ایجاد یک استریم جدید برای این نوع صفحه';
$lang['page_types:select_stream']              = 'استریم';
$lang['page_types:theme_layout_label']         = 'صفحه بندی قالب';
$lang['page_types:save_as_files']              = 'ذخیره به عنوان فایل';
$lang['page_types:title_label']                = 'برچسب عنوان';
$lang['page_types:sync_files']                 = 'همزمان کردن فایل ها';

// titles
$lang['page_types:list_title']                 = 'نوع-صفحه ها';
$lang['page_types:list_title_sing']            = 'نوع-صفحه';
$lang['page_types:create_title']               = 'نوع-صفحه ی جدید';
$lang['page_types:edit_title']                 = 'ویرایش نوع-صفحه ی "%s"';

// messages
$lang['page_types:no_pages']                   = 'رکوردی وجود ندارد.';
$lang['page_types:create_success_add_fields']  = 'نوع-صفحه جدید ایجاد شد حالا می توانید فیلد هایی که می خواهید این نوع-صفحه داشته باشد را اضافه نمایید.';
$lang['page_types:create_success']             = 'page layout ایجاد شد.';
$lang['page_types:success_add_tag']            = 'فیلد مرود نظر اضافه شد هرچند برای اینکه در صفحه بتوانید آن را مشاهد کنید می باید تگ آن را در قالب بندی این نوع صفحه وارد کنید.';
$lang['page_types:create_error']               = 'page layout ایجاد نشد.';
$lang['page_types:page_type.not_found_error']  = 'این page layout  وجود ندارد.';
$lang['page_types:edit_success']               = '"%s" ذخیره شد.';
$lang['page_types:delete_home_error']          = 'شما نمی توانید layout  پیشفرض را حذف نمایید.';
$lang['page_types:delete_success']             = 'page layout مورد نظر دلیت شد.';
$lang['page_types:mass_delete_success']        = '%s مورد از نوع-صفحه ها حذف شدند.';
$lang['page_types:delete_none_notice']         = 'هیچ موردی حذف نشد.';
$lang['page_types:already_exist_error']        = 'جدولی با این نام همینک وجود دارد لطفا یک نام دیگر انتخاب نماید.';
$lang['page_types:_check_pt_slug_msg']         = 'نام انگلیسی مربوط به نوع-صفحه باید یکتا باشد.';

$lang['page_types:variable_introduction']      = 'در اینجا دو نوع متغییر قابل دسترس است.';
$lang['page_types:variable_title']             = 'دربرگیرنده ی عنوان صفحه ';
$lang['page_types:variable_body']              = 'دربرگیرنده ی محتوای HTML صفحه.';
$lang['page_types:sync_notice']                = 'تنها قادر به همزمانسازی از file system است.';
$lang['page_types:sync_success']               = 'فایل ها همزمانسازی شدند.';
$lang['page_types:sync_fail']                  = 'نتوانستیم فایل ها را همزمانسازی کنیم';

// Instructions
$lang['page_types:stream_instructions']        = 'این استریم فیلد های سفاری شما را در بر می گیرد شما می توانید یک استریم جدید ایجاد کنیم و یا ما آن را برای شما ایجاد خواهیم کرد.';
$lang['page_types:saf_instructions']           = 'تیک زدن این قسمت باعث می شود که یک فایل جدید به همره تمام css و js هایی که ایجاد کرده اید در فولدر assets/page_types برای شما ایجاد شود.';
$lang['page_types:content_label_instructions'] = 'این قسمت تب مربوط به استریم نگهدارینده ی فیلد های شما را تغییر نام می دهد.';
$lang['page_types:title_label_instructions']   = 'This renames the page title field from "Title". This is useful if you are using "Title" as something else, like "Product Name" or "Team Member Name".';

// Misc
$lang['page_types:delete_message']             = 'Are you sure you want to delete this page type? This will delete <strong>%s</strong> pages using this layout, any page children of these pages, and any stream entries associated with these pages. <strong>This cannot be undone.</strong> ';

$lang['page_types:delete_streams_message']     = 'This will also delete the <strong>%s stream</strong> associated with this page type.';