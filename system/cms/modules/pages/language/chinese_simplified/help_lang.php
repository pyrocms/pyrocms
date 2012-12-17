<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>概观</h4>
<p>页面模块是一个简单但强大的方式来管理您的网站上的静态内容。
页面布局，可管理和嵌入式部件没有编辑模板文件。</p>

<h4>管理页面</h4><hr>
<h6>页面内容</h6>
<p>当选择你的页面标题记得默认的页面布局将显示上述页面内容页面的标题。
现在使用所见即所得的编辑器创建您的网页内容。
当您准备的页面，可见生活状态设置游客，这将是在显示的URL访问。
你还必须去设计 - >导航和创建一个新的导航链接，如果您想您的网页
显示菜单中，或从下拉菜单中选择一个导航区，如果你想让它自动创建。</p>

<h6>Meta属性</h6>
<p>Meta标题通常用于在搜索结果中的标题，被认为是携带重量在网页排名的重要。<br />
Meta关键字是描述你的网站内容和搜索引擎的利益的话。<br />
Meta描述的是一个页面的简短描述，可用于搜索片段，如果搜索引擎认为它相关的搜索。</p>

<h6>设计</h6>
<p>“设计”选项卡允许您选择自定义页面布局，并选择申请此页面上不同的CSS样式只。
就如何最好地利用页面布局的说明，请参阅下面的页面布局部分.</p>

<h6>脚本</h6>
<p>你可以将这里的JavaScript追加到页的<head>里面.</p>

<h6>选项</h6>
<p>允许您打开的意见和RSS订阅此页。您还可以通过设置访问字段限制，以在特定的用户群体已登录的页面。
如果启用了RSS提要，访问者可以订阅此页，他们将在自己的RSS阅读器接收每个子页.</p>
<p>\"Require an exact uri match\"字段是一个聪明的小工具，它允许你通过URL中的参数需要一个确切的URI匹配. 默认情况下, 当你访问site_url('products/acme-widgets')时，PyroCMS用\"acme-widgets\"查找在\"product\"下的子页面。
如果PyroCMS发现在Product下面没有一个页面命名为 \"Acme Widgets\"，于是PyroCMS将会调用 Products 方法，并传递'acme-widgets'做为一个参数。这样的思路使得它很容易将参数传递给嵌入式标签。
一个使用Streams组件在products页面上显示'acme-widgets'的例子：
<pre><code>{{ streams:cycle stream={url:segments segment=&quot;2&quot;} }}
    {{ entries }}
        {{ company_intro }}
        {{ owner_name }}
        {{ owner_phone }}
    {{ /entries }}
{{ /streams:cycle }}</code></pre></p>

<h4>页面布局</h4><hr>
<p>页面布局使您可以控制​​页面布局，无需修改主题文件。创建页面布局时，你也可以选择主题布局文件。
你可以嵌入到页面布局，而不是把他们在每一页的标签。
例如：如果你有一个Twitter的饲料部件要在每一页的底部，你可以放置在页面布局中的widget标签显示：</p><br />
<pre><code>
{{ page:title }}
{{ page:body }}

&lt;div class=&quot;my-twitter-widget&quot;&gt;
	{{ widgets:instance id=&quot;1&quot; }}
&lt;/div&gt;
</code></pre>
<p>现在，你可以应用CSS样式\"my-twitter-widget\" 类在CSS标签。</p>";