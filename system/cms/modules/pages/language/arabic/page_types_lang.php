<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'Basic Info'; #translate

// labels
$lang['page_types:updated_label']              = 'آخر تحديث';
$lang['page_types:layout']                     = 'Layout'; #translate
$lang['page_types:auto_create_stream']         = 'أنشئ جدول بيانات جديد';
$lang['page_types:select_stream']              = 'جدول البيانات';
$lang['page_types:theme_layout_label']         = 'تخطيط السّمة';
$lang['page_types:save_as_files']              = 'Save as Files'; #translate
$lang['page_types:content_label']              = 'Content Tab Label'; #translate
$lang['page_types:title_label']                = 'Title Label'; #translate
$lang['page_types:sync_files']                 = 'Sync Files'; #translate

// titles
$lang['page_types:list_title']                 = 'سرد مُخططات الصفحات';
$lang['page_types:list_title_sing']            = 'Page Type'; #translate
$lang['page_types:create_title']               = 'إضافة تخطيط صفحة';
$lang['page_types:edit_title']                 = 'تعديل تخطيط الصفحة "%s"';

// messages
$lang['page_types:no_pages']                   = 'لا يوجد أي تخطيطات صفحات.';
$lang['page_types:create_success_add_fields']  = 'You have created a new page type; now add the fields that you want your page to have.'; #translate
$lang['page_types:create_success']             = 'تم إنشاء تخطيط الصفحة.';
$lang['page_types:success_add_tag']            = 'The page field has been added. However before its data will be output you must insert its tag into the Page Type\'s Layout textarea'; #translate
$lang['page_types:create_error']               = 'لم يتم إنشاء تخطيط الصفحة.';
$lang['page_types:page_type.not_found_error']  = 'تخطيط الصفحة هذا غير موجود.';
$lang['page_types:edit_success']               = 'تم حفظ تخطيط الصفحة "%s".';
$lang['page_types:delete_home_error']          = 'لا يمكنك حذف التخطيط الإفتراضي.';
$lang['page_types:delete_success']             = 'تم حذف تخطيط الصفحة #%s.';
$lang['page_types:mass_delete_success']        = 'تم حذف %s تخطيط صفحة.';
$lang['page_types:delete_none_notice']         = 'لم يتم حذف أي تخطيط صفحة.';
$lang['page_types:already_exist_error']        = 'هناك جدول بهذا الإسم موجود. رجاءً اختر اسماً مختلفاً لنوع الصفحة هذه.';
$lang['page_types:_check_pt_slug_msg']         = 'Your page type slug must be unique.'; #translate

$lang['page_types:variable_introduction']      = 'في مربّع الإدخال هذا يوجد متغيّران متوفّران.';
$lang['page_types:variable_title']             = 'يحتوي عنوان الصفحة.';
$lang['page_types:variable_body']              = 'يحتوي نص HTML للصفحة.';
$lang['page_types:sync_notice']                = 'Only able to sync %s from the file system.'; #translate
$lang['page_types:sync_success']               = 'Files synced successfully.'; #translate
$lang['page_types:sync_fail']                  = 'Unable to sync your files.'; #translate

// Instructions
$lang['page_types:stream_instructions']        = 'This stream will hold the custom fields for your page type. You can choose a new stream, or one will be created for you.'; #translate
$lang['page_types:saf_instructions']           = 'Checking this will save your page layout file, as well as any custom CSS and JS as flat files in your assets/page_types folder.'; #translate
$lang['page_types:content_label_instructions'] = 'This renames the tab that holds your page type stream fields.'; #translate
$lang['page_types:title_label_instructions']   = 'This renames the page title field from "Title". This is useful if you are using "Title" as something else, like "Product Name" or "Team Member Name".'; #translate

// Misc
$lang['page_types:delete_message']             = 'Are you sure you want to delete this page type? This will delete <strong>%s</strong> pages using this layout, any page children of these pages, and any stream entries associated with these pages. <strong>This cannot be undone.</strong> '; #translate

$lang['page_types:delete_streams_message']     = 'This will also delete the <strong>%s stream</strong> associated with this page type.'; #translate