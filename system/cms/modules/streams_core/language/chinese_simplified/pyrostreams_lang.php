<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "存储此字段时出错。";
$lang['streams:field_add_success']						= "此字段被添加成功。";
$lang['streams:field_update_error']						= "更新此字段时出错。";
$lang['streams:field_update_success']					= "此字段更新成功。";
$lang['streams:field_delete_error']						= "删除此字段时出错。";
$lang['streams:field_delete_success']					= "此字段被删除";
$lang['streams:view_options_update_error']				= "更新此查看选项时出错。";
$lang['streams:view_options_update_success']			= "查看选项更新成功。";
$lang['streams:remove_field_error']						= "移除此字段出错。";
$lang['streams:remove_field_success']					= "此字段移除成功。";
$lang['streams:create_stream_error']					= "创建您的流出现问题。";
$lang['streams:create_stream_success']					= "流已成功创建。";
$lang['streams:stream_update_error']					= "更新此流发生问题。";
$lang['streams:stream_update_success']					= "成功更新此流。";
$lang['streams:stream_delete_error']					= "删除此流发生问题。";
$lang['streams:stream_delete_success']					= "成功删除此流。";
$lang['streams:stream_field_ass_add_error']				= "添加此字段到流出错。";
$lang['streams:stream_field_ass_add_success']			= "此字段被成功添加到流。";
$lang['streams:stream_field_ass_upd_error']				= "更新这个字段赋值出错。";
$lang['streams:stream_field_ass_upd_success']			= "成功更新这个字段赋值";
$lang['streams:delete_entry_error']						= "删除该条目出错。";
$lang['streams:delete_entry_success']					= "成功删除该条目。";
$lang['streams:new_entry_error']						= "添加该条目出错。";
$lang['streams:new_entry_success']						= "成功添加该条目。";
$lang['streams:edit_entry_error']						= "更新该条目出错。";
$lang['streams:edit_entry_success']						= "成功更新该条目。";
$lang['streams:delete_summary']							= "您确定要删除 <strong>%s</strong> 流? 这将会<strong>永久性地删除 %s %s</strong>.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "没有任何流。";
$lang['streams:invalid_stream']							= "无效的流。";
$lang['streams:not_valid_stream']						= "不是一个有效的流。";
$lang['streams:invalid_stream_id']						= "无效的流ID.";
$lang['streams:invalid_row']							= "无效的行。";
$lang['streams:invalid_id']								= "无效的ID。";
$lang['streams:cannot_find_assign']						= "未能发现此字段赋值。";
$lang['streams:cannot_find_pyrostreams']				= "未能发现PyroStreams。";
$lang['streams:table_exists']							= " %s 数据表已经存在。";
$lang['streams:no_results']								= "没有结果。";
$lang['streams:no_entry']								= "不能找到该条目。";
$lang['streams:invalid_search_type']					= "不是一个有效的查询种类。";
$lang['streams:search_not_found']						= "未能找到查询结果。";

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "此项标号已经存在。";
$lang['streams:not_mysql_safe_word']					= "%s 项为MySQL保留字段。.";
$lang['streams:not_mysql_safe_characters']				= "%s 项包括非法字符。";
$lang['streams:type_not_valid']							= "请选择一个有效的项目种类。";
$lang['streams:stream_slug_not_unique']					= "此流标号已经存在。";
$lang['streams:field_unique']							= "%s 项必须是唯一的。";
$lang['streams:field_is_required']						= "%s 项是必填的。";
$lang['streams:date_out_or_range']						= "您选择的日期在有效日期以外。";

/* Field Labels */

$lang['streams:label.field']							= "字段";
$lang['streams:label.field_required']					= "必填字段";
$lang['streams:label.field_unique']						= "唯一字段";
$lang['streams:label.field_instructions']				= "字段指导";
$lang['streams:label.make_field_title_column']			= "标记此字段的标题栏";
$lang['streams:label.field_name']						= "字段名称";
$lang['streams:label.field_slug']						= "字段标号";
$lang['streams:label.field_type']						= "字段种类";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "创建于";
$lang['streams:created_date']							= "创建时间";
$lang['streams:updated_date']							= "更新时间";
$lang['streams:value']									= "数字";
$lang['streams:manage']									= "管理";
$lang['streams:search']									= "查询";
$lang['streams:stream_prefix']							= "流前缀";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "显示输入或编辑数据在表格里。";
$lang['streams:instr.stream_full_name']					= "您的流全名";
$lang['streams:instr.slug']								= "小写，只接受字母和下划线。";

/* Titles */

$lang['streams:assign_field']							= "分配字段流";
$lang['streams:edit_assign']							= "编辑字段流";
$lang['streams:add_field']								= "创建字段";
$lang['streams:edit_field']								= "编辑字段";
$lang['streams:fields']									= "字段";
$lang['streams:streams']								= "流";
$lang['streams:list_fields']							= "字段列表";
$lang['streams:new_entry']								= "新的条目";
$lang['streams:stream_entries']							= "流条目";
$lang['streams:entries']								= "条目";
$lang['streams:stream_admin']							= "流管理";
$lang['streams:list_streams']							= "流列表";
$lang['streams:sure']									= "您确定?";
$lang['streams:field_assignments'] 						= "流字段赋值";
$lang['streams:new_field_assign']						= "新的字段赋值";
$lang['streams:stream_name']							= "流名称";
$lang['streams:stream_slug']							= "流标号";
$lang['streams:about']									= "关于";
$lang['streams:total_entries']							= "全部条目";
$lang['streams:add_stream']								= "添加流";
$lang['streams:edit_stream']							= "编辑流";
$lang['streams:about_stream']							= "编辑此流";
$lang['streams:title_column']							= "标题列";
$lang['streams:sort_method']							= "排序项";
$lang['streams:add_entry']								= "添加条目";
$lang['streams:edit_entry']								= "编辑条目";
$lang['streams:view_options']							= "查看选项";
$lang['streams:stream_view_options']					= "流的查看选项";
$lang['streams:backup_table']							= "备份流表";
$lang['streams:delete_stream']							= "删除流表";
$lang['streams:entry']									= "条目";
$lang['streams:field_types']							= "字段种类";
$lang['streams:field_type']								= "字段种类";
$lang['streams:database_table']							= "数据表";
$lang['streams:size']									= "大小";
$lang['streams:num_of_entries']							= "条目数量";
$lang['streams:num_of_fields']							= "字段数量";
$lang['streams:last_updated']							= "最后更新";
$lang['streams:export_schema']							= "导出流";

/* Startup */

$lang['streams:start.add_one']							= "从这里添加";
$lang['streams:start.no_fields']						= "您还没有创建任何字段。要启动，您可以";
$lang['streams:start.no_assign'] 						= "此流看起来没有任何字段。要启动，你可以";
$lang['streams:start.add_field_here']					= "从这里添加字段";
$lang['streams:start.create_field_here']				= "从这里创建字段";
$lang['streams:start.no_streams']						= "没有任何流，要启动，您可以";
$lang['streams:start.no_streams_yet']					= "没有任何流。";
$lang['streams:start.adding_one']						= "添加";
$lang['streams:start.no_fields_to_add']					= "没有字段被添加";
$lang['streams:start.no_fields_msg']					= "没有字段添加到该流。在PyroStreams，字段类型可以在流之间共享，并且被添加到流之前，必须创建。您可以通过";
$lang['streams:start.adding_a_field_here']				= "从这里添加字段";
$lang['streams:start.no_entries']						= "<strong>%s</strong> 没有任何条目。要启动，您可以";
$lang['streams:add_fields']								= "赋值字段";
$lang['streams:no_entries']								= 'No entries'; #translate
$lang['streams:add_an_entry']							= "添加条目";
$lang['streams:to_this_stream_or']						= "对此流或";
$lang['streams:no_field_assign']						= "没有字段赋值";
$lang['streams:no_fields_msg_first']					= "此流不包含任何字段。";
$lang['streams:no_field_assign_msg']					= "在您开始输入数据前，您需要";
$lang['streams:add_some_fields']						= "分配给一些字段";
$lang['streams:start.before_assign']					= "在分配字段的流之前，你需要创建一个字段。您可以";
$lang['streams:start.no_fields_to_assign']				= "看起来像没有字段可以分配。在分配一个字段前，你必须";

/* Buttons */

$lang['streams:yes_delete']								= "是的，删除";
$lang['streams:no_thanks']								= "不用谢";
$lang['streams:new_field']								= "新字段";
$lang['streams:edit']									= "编辑";
$lang['streams:delete']									= "删除";
$lang['streams:remove']									= "移除";
$lang['streams:reset']									= "重置";

/* Misc */

$lang['streams:field_singular']							= "字段";
$lang['streams:field_plural']							= "字段";
$lang['streams:by_title_column']						= "按标题列";
$lang['streams:manual_order']							= "手动排序";
$lang['streams:stream_data_line']						= "编辑基本的流数据.";
$lang['streams:view_options_line'] 						= "选择哪些列应该是可见的名单上的数据页.";
$lang['streams:backup_line']							= "备份并下载流数据库到ZIP文件";
$lang['streams:permanent_delete_line']					= "永久删除流数据";
$lang['streams:choose_a_field_type']					= "选择一个字段种类";
$lang['streams:choose_a_field']							= "选择一个字段";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "验证码库初始化";
$lang['recaptcha_no_private_key']						= "您没有提供一个API密钥验证码";
$lang['recaptcha_no_remoteip'] 							= "为了安全起见，你必须通过远程IP验证码";
$lang['recaptcha_socket_fail'] 							= "无法打开Socket";
$lang['recaptcha_incorrect_response'] 					= "不正确的安全图像响应";
$lang['recaptcha_field_name'] 							= "安全图片";
$lang['recaptcha_html_error'] 							= "加载错误的安全图片。请稍后再试一次";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "最大长度";
$lang['streams:upload_location'] 						= "上传地址";
$lang['streams:default_value'] 							= "默认值";

$lang['streams:menu_path']								= 'Menu Path'; #translate
$lang['streams:about_instructions']						= 'A short description of your stream.'; #translate
$lang['streams:slug_instructions']						= 'This will also be the database table name for your stream.'; #translate
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.'; #translate
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate

/* End of file pyrostreams_lang.php */
