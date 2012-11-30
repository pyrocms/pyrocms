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

// General
$lang['files:files_title']					= 'ไฟล์';
$lang['files:fetching']						= 'กำลังดึงข้อมูล ...';
$lang['files:fetch_completed']				= 'เสร็จ';
$lang['files:save_failed']					= 'ขออภัย ที่ไม่สามารถบันทึกการเปลี่ยนแปลงได้';
$lang['files:item_created']					= '"%s" ถูกสร้างขึ้น';
$lang['files:item_updated']					= '"%s" ถูกแก้ไข';
$lang['files:item_deleted']					= '"%s" ถูกลบ';
$lang['files:item_not_deleted']				= '"%s" ไม่สามารถลบได้';
$lang['files:item_not_found']				= 'ขออภัยไม่พบ "%s"';
$lang['files:sort_saved']					= 'การจัดเรียงถูกบันทึก';
$lang['files:no_permissions']				= 'คุณไม่ได้รับสิทธิ์';

// Labels
$lang['files:activity']						= 'กิจกรรม';
$lang['files:places']						= 'สถานที่';
$lang['files:back']							= 'ย้อนกลับ';
$lang['files:forward']						= 'ถัดไป';
$lang['files:start']						= 'เริ่มที่อัปโหลด';
$lang['files:details']						= 'รายละเอียด';
$lang['files:id']							= 'ID'; #translate
$lang['files:name']							= 'ชื่อ';
$lang['files:slug']							= 'Slug';
$lang['files:path']							= 'ที่อยู่';
$lang['files:added']						= 'วันที่เพิ่ม';
$lang['files:width']						= 'กว้าง';
$lang['files:height']						= 'สูง';
$lang['files:ratio']						= 'อัตราส่วน';
$lang['files:alt_attribute']				= 'alt Attribute'; #translate
$lang['files:full_size']					= 'ขนาดเต็ม์';
$lang['files:filename']						= 'ชื่อไฟล์';
$lang['files:filesize']						= 'ขนาดไฟล์';
$lang['files:download_count']				= 'นับการดาวน์โหลด';
$lang['files:download']						= 'ดาวน์โหลด';
$lang['files:location']						= 'ที่อยู่';
$lang['files:keywords']						= 'Keywords'; #translate
$lang['files:toggle_data_display']			= 'Toggle Data Display'; #translate
$lang['files:description']					= 'คำอธิบาย';
$lang['files:container']					= 'Container';
$lang['files:bucket']						= 'Bucket';
$lang['files:check_container']				= 'ตรวจสอบ';
$lang['files:search_message']				= 'พิมพ์แล้วกด Enter';
$lang['files:search']						= 'ค้นหา';
$lang['files:synchronize']					= 'ซิงค์';
$lang['files:uploader']						= 'วางไฟล์ที่นี่ <br />หรือ<br />เลือกไฟล์';
$lang['files:replace_file']					= 'Replace file'; #translate

// Context Menu
$lang['files:refresh']						= 'Refresh'; #translate
$lang['files:open']							= 'เปิด';
$lang['files:new_folder']					= 'สร้างโฟลเดอร์ใหม่';
$lang['files:upload']						= 'อัพโหลด';
$lang['files:rename']						= 'แก้ไขชื่อ';
$lang['files:replace']	  					= 'Replace'; # translate
$lang['files:delete']						= 'ลบ';
$lang['files:edit']							= 'แก้ไข';
$lang['files:details']						= 'รายละเอียด';

// Folders

$lang['files:no_folders']					= 'ไฟล์และโฟลเดอร์มีการจัดการที่เหมือนบนเดสก์ทอปของคุณ คลิกขวาในพื้นที่ด้านล่างข้อความนี้เพื่อสร้างโฟลเดอร์แรกของคุณ จากนั้นคลิกขวาบนโฟลเดอร์ที่ต้องการเพื่อเปลี่ยนชื่อ, ลบ, อัปโหลดไฟล์ หรือเปลี่ยนรายละเอียดต่างๆเช่นการเชื่อมโยงไปยังตำแหน่งคอมพิวเตอร์กลุ่มเมฆ';
$lang['files:no_folders_places']			= 'โฟลเดอร์ที่คุณสร้างจะถูกแสดงขึ้นที่นี่ ในเมนูต้นไม้ที่สามารถขยายและหดตัว คลิกที่ "สถานที่" เพื่อดูโฟลเดอร์ราก';
$lang['files:no_folders_wysiwyg']			= 'ไม่มีโฟลเดอร์ที่ถูกสร้างขึ้น';
$lang['files:new_folder_name']				= 'โฟลเดอรใหม่';
$lang['files:folder']						= 'โฟลเดอร์';
$lang['files:folders']						= 'โฟลเดอร์';
$lang['files:select_folder']				= 'เลือกโฟลเดอร์';
$lang['files:subfolders']					= 'โฟลเดอร์ย่อย';
$lang['files:root']							= 'ราก';
$lang['files:no_subfolders']				= 'ไม่มีโฟลเดอร์ย่อย';
$lang['files:folder_not_empty']				= 'คุณต้องลบเนื้อหาขใน "%s" ก่อน';
$lang['files:mkdir_error']					= 'เราไม่สามารถสร้าง %s คุณต้องสร้างมันขึ้นมาด้วยตนเอง';
$lang['files:chmod_error']					= 'ไดเรกทอรีอัปโหลดไม่สามารถเขียนได้ ลองตั้งสิทธิ์เป็น 0777';
$lang['files:location_saved']				= 'ตำแหน่งที่ตั้งของโฟลเดอร์ได้รับการบันทึก';
$lang['files:container_exists']				= '"%s" มีอยู่แล้ว. บันทึกการเชื่อมโยงเนื้อหาไปยังโฟลเดอร์นี้';
$lang['files:container_not_exists']			= '"%s" ไม่มีอยู่ในบัญชีของคุณ. บันทึกและเราจะพยายามสร้างมันขึ้นมา ';
$lang['files:error_container']				= '"%s" ไม่สามารถสร้างได้และเราไม่สามารถทราบเหตุผล';
$lang['files:container_created']			= '"%s" ได้ถูกสร้างขึ้นและมีการเชื่อมโยงไปยังโฟลเดอร์นี้';
$lang['files:unwritable']					= '"%s" เขียนทับไม่ได้, กรุณาตั้งสิทธฺ์เป็น 0777';
$lang['files:specify_valid_folder']			= 'คุณต้องระบุโฟลเดอร์ให้ถูกต้องในการอัปโหลดไฟล์';
$lang['files:enable_cdn']					= 'คุณต้องเปิดการใช้งาน CDN สำหรับ "%s" ผ่านทางแผงควบคุมของคุณก่อนที่จะซิงค์โครไนต์';
$lang['files:synchronization_started']		= 'เริ่มการซิงค์โครไนต์';
$lang['files:synchronization_complete']		= 'ซิงค์โครไนต์สำหรับ "%s" เสร็จเรียบร้อย';
$lang['files:untitled_folder']				= 'โฟลเดอร์ไม่ได้ตั้งชื่อ';

// Files
$lang['files:no_files']						= 'ไม่พบไฟล์';
$lang['files:file_uploaded']				= '"%s" ถูกอัพโหลดแล้ว';
$lang['files:unsuccessful_fetch']			= 'เราไม่สามารถดึง "%s" ได้ คุณแน่ใจหรือปล่าวว่าไฟล์นี้เปิดให้เข้าได้?';
$lang['files:invalid_container']			= '"%s" ไม่ปรากฏว่าเก็บได้ถูกต้อง';
$lang['files:no_records_found']				= 'ไม่พบข้อมูลซักแถว';
$lang['files:invalid_extension']			= '"%s" มีนามสกุลไฟล์ที่ไม่ได้รับอนุญาต';
$lang['files:upload_error']					= 'อัพโหลดไฟล์ล้มเหลว';
$lang['files:description_saved']			= 'คำอธิบายไฟล์ที่ได้รับการบันทึกไว้';
$lang['files:alt_saved']					= 'The image alt attribute has been saved'; #translate
$lang['files:file_moved']					= '"%s" ได้ถูกย้ายเรียบร้อยแล้ว';
$lang['files:exceeds_server_setting']		= 'เซิร์ฟเวอร์ไม่สามารถจัดการไฟล์ที่มีขนาดใหญ่ได้';
$lang['files:exceeds_allowed']				= 'ไฟล์เกินขนาดสูงสุดที่อนุญาต';
$lang['files:file_type_not_allowed']		= 'ไฟล์ประเภทนี้ไม่ได้รับอนุญาต';
$lang['files:replace_warning']				= 'Warning: Do not replace a file with a file of a different type (e.g. .jpg with .png)'; #translate
$lang['files:type_a']						= 'เสียง';
$lang['files:type_v']						= 'วิดีโอ';
$lang['files:type_d']						= 'เอกสาร';
$lang['files:type_i']						= 'รูปภาพ';
$lang['files:type_o']						= 'อื่น ๆ';

/* End of file files_lang.php */