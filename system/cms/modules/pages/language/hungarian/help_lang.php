<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>Overview</h4>
<p>The pages module is a simple but powerful way to manage static content on your site.
Page layouts can be managed and widgets embedded without ever editing the template files.</p>

<h4>Managing Pages</h4><hr>
<h6>Page Content</h6>
<p>When choosing your page title remember that the default page layout will display the page title above the page content. 
Now create your page content using the WYSIWYG editor. 
When you are ready for the page to be visible to visitors set the status to Live and it will be accessible at the URL shown. 
<strong>You must also go to Design -> Navigation and create a new navigation link if you want your page to show up in the menu.</strong></p>

<h6>Meta data</h6>
<p>The meta title is generally used as the title in search results and is believed to carry significant weight in page rank.<br />
Meta keywords are words that describe your site content and are for the benefit of search engines only.<br />
The meta description is a short description of this page and may be used as the search snippet if the search engine deems it relevant to the search.</p>

<h6>Design</h6>
<p>The design tab allows you to select a custom page layout and optionally apply different css styles to it on this page only. 
Refer to the Page Layouts section below for instructions on how to best use Page Layouts.</p>

<h6>Script</h6>
<p>You may place javascript here that you would like appended to the < head > of the page.</p>

<h6>Options</h6>
<p>Allows you to turn on comments and an rss feed for this page. 
If the RSS feed is enabled a visitor can subscribe to this page and they will receive each child page in their rss reader.</p>

<h6>Revisions</h6>
<p>Revisions is a very powerful and handy feature for editing an existing page. 
Let's say a new employee really messes up a page edit. 
Just select a date that you would like to revert the page to and click Save! 
You can even compare revisions to see what has changed.</p>

<h4>Page Layouts</h4><hr>
<p>Page layouts allows you to control the layout of the page without modifying the theme files. 
You can embed tags into the page layout instead of placing them in every page. 
For example: If you have a twitter feed widget that you want to display at the bottom of every page you can just place the widget tag in the page layout:
<pre><code>
{{ page:title }}
{{ page:body }}

< div class=\"my-twitter-widget\" >
	{{ widgets:instance id=\"1\" }}
< /div >
</code></pre>
Now you can apply css styling to the \"my-twitter-widget\" class in the CSS tab.</p>"; #translate