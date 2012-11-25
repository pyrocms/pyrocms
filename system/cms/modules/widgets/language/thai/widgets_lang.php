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

// sidebar
$lang['widgets.available_title']        = 'วิดเจ็ตที่เปิดใช้งานอยู่';
$lang['widgets.widget_area_wrapper']    = 'พื้นที่ที่เปิดใช้งาน';
$lang['widgets.instructions']           = 'ลากและวางเพื่อติดตั้ง';


$lang['widgets.instances']            	= 'Instances';
$lang['widgets.areas']            		= 'พื้นที่';

// Widgets
$lang['widgets.widget']                 = 'วิดเจ็ต';
$lang['widgets.widget_author']          = 'ผู้เขียน';
$lang['widgets.widget_short_name']      = 'ชื่อย่อ';
$lang['widgets.widget_version']         = 'รุ่น';
$lang['widgets.status_label']			= 'สถานะ';

$lang['widgets.inactive_title'] 		= 'วิดเจ็ตที่ปิดใช้งาน';
$lang['widgets.active_title'] 			= 'วิดเจ็ตที่เปิดใช้งาน';

// Widget area titles
$lang['widgets.add_area']               = 'เพิ่มพื้นที่';
$lang['widgets.delete_area']            = 'ลบพื้นที่';
$lang['widgets.edit_area']              = 'แก้ไขพื้นที่';

// Widget area field names
$lang['widgets.widget_area']            = 'พื้นที่';
$lang['widgets.widget_area_title']      = 'ชื่อพื้นที่';
$lang['widgets.widget_area_slug']       = 'ชื่อย่อพื้นที่';

$lang['widgets.view_code']				= 'ดูโต้ด'; #translate

$lang['widgets.instance_title']         = 'ชื่อ';
$lang['widgets.show_title']				= 'แสดงชื่อวิดเจ็ตหรือไม่?'; #translate
$lang['widgets.tag_title']              = 'แท็ก';

$lang['widgets.no_available_widgets']	= 'ไม่มีวิดเจ็ตเปิดใช้งาน';

$lang['widgets.content_label']			= 'Content';
$lang['widgets.context_label']			= 'Context';
$lang['widgets.show:onlyon']			= 'Show widget only on page(s) listed'; #translate
$lang['widgets.show:noton']				= 'Show widget on every page except listed'; #translate
$lang['widgets.show:directions']		= 'Enter one page per line as Pyro page slugs. '. 
										  '&#60;blog&#62; is used for all blog pages and &#60;home&#62; is used for the homepage. ' .
										  'You may also allow/disallow specific blog categories and pages within a category by using &#60;category:category_slug&#62;. ' .
										  'All pages in a custom module may be allowed/disallowed with &#60;module:module_slug&#62;.'; #translate