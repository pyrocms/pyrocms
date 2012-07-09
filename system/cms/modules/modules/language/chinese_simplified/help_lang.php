<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>概观</h4>
<p>插件模块允许管理员上传，安装，卸载第三方模块。</p>

<h4>上传</h4>
<p>新模块必须是在一个zip文件和文件夹必须命名为模块相同。
例如，如果你是“论坛”上传模块的文件夹必须命名为'论坛'而不是'test_forums“。</p>

<h4>禁用，卸载或删除一个模块</h4>
<p如果你想从模块的前端，并从管理菜单，你可以简单地禁用模块。
如果你做的数据，但可能需要重新安装在未来的模块，你可以卸载它。
<font color=\"red\">附注：这将删除所有数据库记录</font>如果您完成所有数据库中的记录和源文件，你可以删除它。
<font color=\"red\">这将删除所有源文件，上传文件，并与该模块相关的数据库记录。</font></p>
";