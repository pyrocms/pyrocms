<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "存儲此字段時出錯。";
$lang['streams:field_add_success']						= "此字段被添加成功。";
$lang['streams:field_update_error']						= "更新此字段時出錯。";
$lang['streams:field_update_success']					= "此字段更新成功。";
$lang['streams:field_delete_error']						= "刪除此字段時出錯。";
$lang['streams:field_delete_success']					= "此字段被刪除";
$lang['streams:view_options_update_error']				= "更新此查看選項時出錯。";
$lang['streams:view_options_update_success']			= "查看選項更新成功。";
$lang['streams:remove_field_error']						= "移除此字段出錯。";
$lang['streams:remove_field_success']					= "此字段移除成功。";
$lang['streams:create_stream_error']					= "創建您的流出現問題。";
$lang['streams:create_stream_success']					= "流已成功創建。";
$lang['streams:stream_update_error']					= "更新此流發生問題。";
$lang['streams:stream_update_success']					= "成功更新此流。";
$lang['streams:stream_delete_error']					= "刪除此流發生問題。";
$lang['streams:stream_delete_success']					= "成功刪除此流。";
$lang['streams:stream_field_ass_add_error']				= "添加此字段到流出錯。";
$lang['streams:stream_field_ass_add_success']			= "此字段被成功添加到流。";
$lang['streams:stream_field_ass_upd_error']				= "更新這個字段賦值出錯。";
$lang['streams:stream_field_ass_upd_success']			= "成功更新這個字段賦值";
$lang['streams:delete_entry_error']						= "刪除該條目出錯。";
$lang['streams:delete_entry_success']					= "成功刪除該條目。";
$lang['streams:new_entry_error']						= "添加該條目出錯。";
$lang['streams:new_entry_success']						= "成功添加該條目。";
$lang['streams:edit_entry_error']						= "更新該條目出錯。";
$lang['streams:edit_entry_success']						= "成功更新該條目。";
$lang['streams:delete_summary']							= "您確定要刪除 <strong>%s</strong> 流? 這將會<strong>永久性地刪除 %s %s</strong>.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "沒有任何流。";
$lang['streams:invalid_stream']							= "無效的流。";
$lang['streams:not_valid_stream']						= "不是一個有效的流。";
$lang['streams:invalid_stream_id']						= "無效的流ID.";
$lang['streams:invalid_row']							= "無效的行。";
$lang['streams:invalid_id']								= "無效的ID。";
$lang['streams:cannot_find_assign']						= "未能發現此字段賦值。";
$lang['streams:cannot_find_pyrostreams']				= "未能發現PyroStreams。";
$lang['streams:table_exists']							= " %s 數據表已經存在。";
$lang['streams:no_results']								= "沒有結果。";
$lang['streams:no_entry']								= "不能找到該條目。";
$lang['streams:invalid_search_type']					= "不是一個有效的查詢種類。";
$lang['streams:search_not_found']						= "未能找到查詢結果。";

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "此項標號已經存在。";
$lang['streams:not_mysql_safe_word']					= "%s 項為MySQL保留字段。.";
$lang['streams:not_mysql_safe_characters']				= "%s 項包括非法字符。";
$lang['streams:type_not_valid']							= "請選擇一個有效的項目種類。";
$lang['streams:stream_slug_not_unique']					= "此流標號已經存在。";
$lang['streams:field_unique']							= "%s 項必須是唯一的。";
$lang['streams:field_is_required']						= "%s 項是必填的。";
$lang['streams:date_out_or_range']						= "您選擇的日期在有效日期以外。";

/* Field Labels */

$lang['streams:label.field']							= "字段";
$lang['streams:label.field_required']					= "必填字段";
$lang['streams:label.field_unique']						= "唯一字段";
$lang['streams:label.field_instructions']				= "字段指導";
$lang['streams:label.make_field_title_column']			= "標記此字段的標題欄";
$lang['streams:label.field_name']						= "字段名稱";
$lang['streams:label.field_slug']						= "字段標號";
$lang['streams:label.field_type']						= "字段種類";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "創建於";
$lang['streams:created_date']							= "創建時間";
$lang['streams:updated_date']							= "更新時間";
$lang['streams:value']									= "數字";
$lang['streams:manage']									= "管理";
$lang['streams:search']									= "查詢";
$lang['streams:stream_prefix']							= "流前綴";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "顯示輸入或編輯數據在表格裡。";
$lang['streams:instr.stream_full_name']					= "您的流全名";
$lang['streams:instr.slug']								= "小寫，只接受字母和下劃線。";

/* Titles */

$lang['streams:assign_field']							= "分配字段流";
$lang['streams:edit_assign']							= "編輯字段流";
$lang['streams:add_field']								= "創建字段";
$lang['streams:edit_field']								= "編輯字段";
$lang['streams:fields']									= "字段";
$lang['streams:streams']								= "流";
$lang['streams:list_fields']							= "字段列表";
$lang['streams:new_entry']								= "新的條目";
$lang['streams:stream_entries']							= "流條目";
$lang['streams:entries']								= "條目";
$lang['streams:stream_admin']							= "流管理";
$lang['streams:list_streams']							= "流列表";
$lang['streams:sure']									= "您確定?";
$lang['streams:field_assignments'] 						= "流字段賦值";
$lang['streams:new_field_assign']						= "新的字段賦值";
$lang['streams:stream_name']							= "流名稱";
$lang['streams:stream_slug']							= "流標號";
$lang['streams:about']									= "關於";
$lang['streams:total_entries']							= "全部條目";
$lang['streams:add_stream']								= "添加流";
$lang['streams:edit_stream']							= "編輯流";
$lang['streams:about_stream']							= "編輯此流";
$lang['streams:title_column']							= "標題列";
$lang['streams:sort_method']							= "排序項";
$lang['streams:add_entry']								= "添加條目";
$lang['streams:edit_entry']								= "編輯條目";
$lang['streams:view_options']							= "查看選項";
$lang['streams:stream_view_options']					= "流的查看選項";
$lang['streams:backup_table']							= "備份流表";
$lang['streams:delete_stream']							= "刪除流表";
$lang['streams:entry']									= "條目";
$lang['streams:field_types']							= "字段種類";
$lang['streams:field_type']								= "字段種類";
$lang['streams:database_table']							= "數據表";
$lang['streams:size']									= "大小";
$lang['streams:num_of_entries']							= "條目數量";
$lang['streams:num_of_fields']							= "字段數量";
$lang['streams:last_updated']							= "最後更新";
$lang['streams:export_schema']							= "導出流";

/* Startup */

$lang['streams:start.add_one']							= "從這裡添加";
$lang['streams:start.no_fields']						= "您還沒有創建任何字段。要啟動，您可以";
$lang['streams:start.no_assign'] 						= "此流看起來沒有任何字段。要啟動，你可以";
$lang['streams:start.add_field_here']					= "從這裡添加字段";
$lang['streams:start.create_field_here']				= "從這裡創建字段";
$lang['streams:start.no_streams']						= "沒有任何流，要啟動，您可以";
$lang['streams:start.no_streams_yet']					= "沒有任何流。";
$lang['streams:start.adding_one']						= "添加";
$lang['streams:start.no_fields_to_add']					= "沒有字段被添加";
$lang['streams:start.no_fields_msg']					= "沒有字段添加到該流。在PyroStreams，字段類型可以在流之間共享，並且被添加到流之前，必須創建。您可以通過";
$lang['streams:start.adding_a_field_here']				= "從這裡添加字段";
$lang['streams:start.no_entries']						= "<strong>%s</strong> 沒有任何條目。要啟動，您可以";
$lang['streams:add_fields']								= "賦值字段";
$lang['streams:no_entries']								= 'No entries'; #translate
$lang['streams:add_an_entry']							= "添加條目";
$lang['streams:to_this_stream_or']						= "對此流或";
$lang['streams:no_field_assign']						= "沒有字段賦值";
$lang['streams:no_fields_msg_first']					= "此流不包含任何字段。";
$lang['streams:no_field_assign_msg']					= "在您開始輸入數據前，您需要";
$lang['streams:add_some_fields']						= "分配給一些字段";
$lang['streams:start.before_assign']					= "在分配字段的流之前，你需要創建一個字段。您可以";
$lang['streams:start.no_fields_to_assign']				= "看起來像沒有字段可以分配。在分配一個字段前，你必須";

/* Buttons */

$lang['streams:yes_delete']								= "是的，刪除";
$lang['streams:no_thanks']								= "不用謝";
$lang['streams:new_field']								= "新字段";
$lang['streams:edit']									= "編輯";
$lang['streams:delete']									= "刪除";
$lang['streams:remove']									= "移除";
$lang['streams:reset']									= "重置";

/* Misc */

$lang['streams:field_singular']							= "字段";
$lang['streams:field_plural']							= "字段";
$lang['streams:by_title_column']						= "按標題列";
$lang['streams:manual_order']							= "手動排序";
$lang['streams:stream_data_line']						= "編輯基本的流數據.";
$lang['streams:view_options_line'] 						= "選擇哪些列應該是可見的名單上的數據頁.";
$lang['streams:backup_line']							= "備份並下載流數據庫到ZIP文件";
$lang['streams:permanent_delete_line']					= "永久刪除流數據";
$lang['streams:choose_a_field_type']					= "選擇一個字段種類";
$lang['streams:choose_a_field']							= "選擇一個字段";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "驗證碼庫初始化";
$lang['recaptcha_no_private_key']						= "您沒有提供一個API密鑰驗證碼";
$lang['recaptcha_no_remoteip'] 							= "為了安全起見，你必須通過遠程IP驗證碼";
$lang['recaptcha_socket_fail'] 							= "無法打開Socket";
$lang['recaptcha_incorrect_response'] 					= "不正確的安全圖像響應";
$lang['recaptcha_field_name'] 							= "安全圖片";
$lang['recaptcha_html_error'] 							= "加載錯誤的安全圖片。請稍後再試一次";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "最大長度";
$lang['streams:upload_location'] 						= "上傳地址";
$lang['streams:default_value'] 							= "默認值";

$lang['streams:menu_path']								= 'Menu Path'; #translate
$lang['streams:about_instructions']						= 'A short description of your stream.'; #translate
$lang['streams:slug_instructions']						= 'This will also be the database table name for your stream.'; #translate
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.'; #translate
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate

/* End of file pyrostreams_lang.php */
