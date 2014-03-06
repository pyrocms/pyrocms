<?php defined('BASEPATH') or exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>Overview</h4>
<p>The pages module is a simple but powerful way to manage static content on your site.
Page types can be managed and widgets embedded without ever editing the template files.</p>

<h4>Managing Pages</h4><hr>
<h6>Page Content</h6>
<p>When choosing your page title remember that the default page layout will display the page title above the page content. 
Now create your page content using the WYSIWYG editor. 
When you are ready for the page to be visible to visitors set the status to Live and it will be accessible at the URL shown. 
You must also go to Design -> Navigation and create a new navigation link if you want your page to 
show up in the menu or select a Navigation area from the dropdown if you want it created automatically.</p>

<h6>Meta data</h6>
<p>The meta title is generally used as the title in search results and is believed to carry significant weight in page rank.<br />
Meta keywords are words that describe your site content and are for the benefit of search engines only.<br />
The meta description is a short description of this page and may be used as the search snippet if the search engine deems it relevant to the search.</p>

<h6>Design</h6>
<p>The design tab allows you to select a custom page layout and optionally apply different css styles to it on this page only. 
Refer to the Page Types section below for instructions on how to best use Page Types.</p>

<h6>Script</h6>
<p>You may place javascript here that you would like appended to the &lt;head&gt; of the page.</p>

<h6>Options</h6>
<p>Allows you to turn on comments and an rss feed for this page. You can also restrict a page to specific logged in user groups by setting the Access field. 
If the RSS feed is enabled a visitor can subscribe to this page and they will receive each child page in their rss reader.</p>
<p>The &quot;Require an exact uri match&quot; field is a clever little tool that allows you to pass parameters in the url. By default PyroCMS looks for a page with
the slug of &quot;acme-widgets&quot; that is the child of &quot;products&quot; when you visit ".site_url('products/acme-widgets').". By checking this box in the Products
page you are telling PyroCMS that it is now okay if there isn't a page named Acme Widgets. It will now load Products and 'acme-widgets' will just be a parameter.
This makes it easy to pass parameters to embedded tags. An example using the Streams add-on to display the 'acme-widgets' stream on the Products page: 
<pre><code>{{ streams:cycle stream={url:segments segment=&quot;2&quot;} }}
    {{ entries }}
        {{ company_intro }}
        {{ owner_name }}
        {{ owner_phone }}
    {{ /entries }}
{{ /streams:cycle }}</code></pre></p>

<h4>Page Types</h4><hr>
<p>Page types allows you to control the layout of the page without modifying the theme files. You can also select theme layout files when creating Page Types. 
You can embed tags into the page layout instead of placing them in every page. 
For example: If you have a twitter feed widget that you want to display at the bottom of every page you can just place the widget tag in the page layout:</p><br />
<pre><code>
{{ page:title }}
{{ page:body }}

&lt;div class=&quot;my-twitter-widget&quot;&gt;
	{{ widgets:instance id=&quot;1&quot; }}
&lt;/div&gt;
</code></pre>
<p>Now you can apply css styling to the &quot;my-twitter-widget&quot; class in the CSS tab.</p>";