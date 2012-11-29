<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Chinese Simpplified translation.
 *
 * @author		Kefeng DENG
 * @package		PyroCMS
 * @subpackage 	File Module
 * @category	Modules
 * @link		http://pyrocms.com
 * @date		2012-06-22
 * @version		1.0
 */
// General
$lang['files:files_title']					= '文件';
$lang['files:fetching']						= '收集数据中...';
$lang['files:fetch_completed']				= '结束';
$lang['files:save_failed']					= '不能保存修改';
$lang['files:item_created']					= '创建 "%s" 成功';
$lang['files:item_updated']					= '更新 "%s" 成功';
$lang['files:item_deleted']					= '删除 "%s" 成功';
$lang['files:item_not_deleted']				= '"%s" 不能被删除';
$lang['files:item_not_found']				= '对不起. 未能发现 "%s"';
$lang['files:sort_saved']					= '新排序保存成功';
$lang['files:no_permissions']				= '您未有足够权限';

// Labels
$lang['files:activity']						= '活动';
$lang['files:places']						= '位置';
$lang['files:back']							= '后退';
$lang['files:forward']						= '前进';
$lang['files:start']						= '开始上传';
$lang['files:details']						= '细节';
$lang['files:name']							= '名称';
$lang['files:slug']							= '简写';
$lang['files:path']							= '路径';
$lang['files:added']						= '创建日期';
$lang['files:width']						= '宽度';
$lang['files:height']						= '高度';
$lang['files:ratio']						= '比例';
$lang['files:full_size']					= '原始大小';
$lang['files:filename']						= '文件名';
$lang['files:filesize']						= '文件大小';
$lang['files:download_count']				= '下载次数';
$lang['files:download']						= '下载';
$lang['files:location']						= '位置';
$lang['files:description']					= '描述';
$lang['files:container']					= '容器';
$lang['files:bucket']						= '批量';
$lang['files:check_container']				= '检查正确性';
$lang['files:search_message']				= '输入并回车';
$lang['files:search']						= '搜索';
$lang['files:synchronize']					= '同步';
$lang['files:uploader']						= '拖放文件至此 <br />或<br /> 点击选择文件';

// Context Menu
$lang['files:refresh']						= 'Refresh'; #translate
$lang['files:open']							= '打开';
$lang['files:new_folder']					= '新的文件夹';
$lang['files:upload']						= '上传';
$lang['files:rename']						= '重命名';
$lang['files:delete']						= '删除';
$lang['files:edit']							= '编辑';
$lang['files:details']						= '细节';

// Folders

$lang['files:no_folders']					= '文件和文件夹进行管理，就像他们将在您的桌面上。右键单击在下面这个消息，以创建您的第一个文件夹的面积。然后右击该文件夹重命名，删除，上传文件，或更改，如连接到云位置的详细信息。';
$lang['files:no_folders_places']			= '你创建的文件夹，将显示在一个可以展开和折叠树。 “邻居”，点击查看根文件夹。';
$lang['files:no_folders_wysiwyg']			= '没有任何文件夹';
$lang['files:new_folder_name']				= '未命名';
$lang['files:folder']						= '文件夹';
$lang['files:folders']						= '文件夹';
$lang['files:select_folder']				= '选择一个目录';
$lang['files:subfolders']					= '子目录';
$lang['files:root']							= '根目录';
$lang['files:no_subfolders']				= '无子目录';
$lang['files:folder_not_empty']				= '您必须先删除 "%s" ';
$lang['files:mkdir_error']					= '无法创建 %s. 您必须手动操作。';
$lang['files:chmod_error']					= '上传目录不可写。请确认权限是 0777';
$lang['files:location_saved']				= '目录位置保存成功';
$lang['files:container_exists']				= '"%s" 已经存在。存储链接到该文件夹​​的内容。';
$lang['files:container_not_exists']			= '您的帐号没有 "%s". 请保存，我们将尝试创建。 ';
$lang['files:error_container']				= '未知原因而不能保存 "%s" ';
$lang['files:container_created']			= '"%s" 被保存并连接到本目录';
$lang['files:unwritable']					= '"%s" 是只读属性，请修改权限为 0777';
$lang['files:specify_valid_folder']			= '您必须上传文件到一个有效的目标目录';
$lang['files:enable_cdn']					= '在开始同步前，请为 "%s" 在Rackspace的控制面板上激活CDN。';
$lang['files:synchronization_started']		= '开始同步';
$lang['files:synchronization_complete']		= '与同步 "%s" 成功';
$lang['files:untitled_folder']				= '未命名目录';

// Files
$lang['files:no_files']						= '无文件';
$lang['files:file_uploaded']				= '"%s" 被上传成功';
$lang['files:unsuccessful_fetch']			= '无法获取 "%s". 请确认此文件为公共属性。';
$lang['files:invalid_container']			= '"%s" 为非法容器.';
$lang['files:no_records_found']				= '没有记录';
$lang['files:invalid_extension']			= '文件 "%s" 的后缀被限制';
$lang['files:upload_error']					= '文件上传失败';
$lang['files:description_saved']			= '新的文件描述被保存成功';
$lang['files:file_moved']					= '"%s" 被成功移动';
$lang['files:exceeds_server_setting']		= '服务器不能负担此大型文件';
$lang['files:exceeds_allowed']				= '文件大小超过限制';
$lang['files:file_type_not_allowed']		= '不允许上传此类型文件';
$lang['files:type_a']						= '音频';
$lang['files:type_v']						= '视频';
$lang['files:type_d']						= '文档';
$lang['files:type_i']						= '图片';
$lang['files:type_o']						= '其他';

/* End of file files_lang.php */