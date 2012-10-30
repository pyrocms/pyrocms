<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>概观</h4>
<p>导航模块，控制你的主导航区以及其他链路组。</p>

<h4>导航组</h4>
<p>根据本集团，他们所处在大多数主题的头组是主要的导航显示导航链接。
检查你的主题文件，找出其中导航组在主题文件的支持。
如果你想显示在网站内容的一组使用此标签：{{ navigation:links group=\"your-group-name\" }}） 《/p>

<h4>添加链接</h4>
<p>选择一个链接的标题，然后选择您希望它显示英寸组
链接类型如下：
<ul>
<li>URL: 外部链接 - http://google.com</li>
<li>Site Link: 站内链接 - galleries/portfolio-pictures</li>
<li>Module: 引导用到一个模组的首页</li>
<li>Page: 链接到一个页面</li>
</ul>
目标指定如果此链接打开新的浏览器窗口或标签。
（提示：使用新窗口谨慎，以避免恼人的您的网站访问者。）
类领域，允许您添加一个CSS类到一个单一的链路.</p>
<p></p>

<h4>导航链接</h4>
<p>为了您的链接在管理面板前端的网站上反映出来。
要改变它们出现的顺序简单地拖放它们，直到它们在你喜欢的顺序是.</p>";