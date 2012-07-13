# PyroCMS Blog Module Update


* Version: 2.2.0-dev

## Team

* [Salmane](http://.com/)

## Description

Few modification made to core CMS files:

- system/cms/core/Public_Controller.php ( line 106 - loads blog config file and uses blog_uri for rss feed)

- system/cms/module/settings/controller/admin.php ( line 169 - dynamically change config/blog.php and config/routes.php for blog_uri change)

- system/cms/config/routes.php ( require the blog/routes.php file at bottom of file)

Blog module has been modified to do the following :

- Posts can have a featured image from the pyroimage library

- Posts intro is limited to text

- "Related posts" was added to plugin.

- Posts can be marked as featured ( themes can take advantage of that to show case featured posts)

- Blog name can be changed to any other name. If left blank Blog page becomes Homepage of the site

- Changed post Uri from blog/date/post-title to blog-uri(if applicable)/category-slug/post-title

- Changed category Uri from blog/categories/category-slug to blog-uri(if applicable)/category-slug

notes : 

modules/blog/config folder must be made writable. This is done so that the blog/config/routes.php & blog/config/blog.php are changed dynamically when the blog-uri is changed

a blog.php file was added to the cms config folder.
