<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>概觀</h4>
<p>頁面模塊是一個簡單但強大的方式來管理您的網站上的靜態內容。
頁面佈局，可管理和嵌入式部件沒有編輯模板文件。</p>

<h4>管理頁面</h4><hr>
<h6>頁面內容</h6>
<p>當選擇你的頁面標題記得默認的頁面佈局將顯示上述頁面內容頁面的標題。
現在使用所見即所得的編輯器創建您的網頁內容。
當您準備的頁面，可見生活狀態設置遊客，這將是在顯示的URL訪問。
你還必須去設計 - >導航和創建一個新的導航鏈接，如果您想您的網頁
顯示菜單中，或從下拉菜單中選擇一個導航區，如果你想讓它自動創建。</p>

<h6>Meta屬性</h6>
<p>Meta標題通常用於在搜索結果中的標題，被認為是攜帶重量在網頁排名的重要。<br />
Meta關鍵字是描述你的網站內容和搜索引擎的利益的話。<br />
Meta描述的是一個頁面的簡短描述，可用於搜索片段，如果搜索引擎認為它相關的搜索。</p>

<h6>設計</h6>
<p>「設計」選項卡允許您選擇自定義頁面佈局，並選擇申請此頁面上不同的CSS樣式只。
就如何最好地利用頁面佈局的說明，請參閱下面的頁面佈局部分.</p>

<h6>腳本</h6>
<p>你可以將這裡的JavaScript追加到頁的<head>裡面.</p>

<h6>選項</h6>
<p>允許您打開的意見和RSS訂閱此頁。您還可以通過設置訪問字段限制，以在特定的用戶群體已登錄的頁面。
如果啟用了RSS提要，訪問者可以訂閱此頁，他們將在自己的RSS閱讀器接收每個子頁.</p>
<p>\"Require an exact uri match\"字段是一個聰明的小工具，它允許你通過URL中的參數需要一個確切的URI匹配. 默認情況下, 當你訪問site_url('products/acme-widgets')時，PyroCMS用\"acme-widgets\"查找在\"product\"下的子頁面。
如果PyroCMS發現在Product下面沒有一個頁面命名為 \"Acme Widgets\"，於是PyroCMS將會調用 Products 方法，並傳遞'acme-widgets'做為一個參數。這樣的思路使得它很容易將參數傳遞給嵌入式標籤。
一個使用Streams組件在products頁面上顯示'acme-widgets'的例子：
<pre><code>{{ streams:cycle stream={url:segments segment=&quot;2&quot;} }}
    {{ entries }}
        {{ company_intro }}
        {{ owner_name }}
        {{ owner_phone }}
    {{ /entries }}
{{ /streams:cycle }}</code></pre></p>

<h4>頁面佈局</h4><hr>
<p>頁面佈局使您可以控制​​頁面佈局，無需修改主題文件。創建頁面佈局時，你也可以選擇主題佈局文件。
你可以嵌入到頁面佈局，而不是把他們在每一頁的標籤。
例如：如果你有一個Twitter的飼料部件要在每一頁的底部，你可以放置在頁面佈局中的widget標籤顯示：</p><br />
<pre><code>
{{ page:title }}
{{ page:body }}

&lt;div class=&quot;my-twitter-widget&quot;&gt;
	{{ widgets:instance id=&quot;1&quot; }}
&lt;/div&gt;
</code></pre>
<p>現在，你可以應用CSS樣式\"my-twitter-widget\" 類在CSS標籤。</p>";