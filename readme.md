# Fizl (Beta)

Fizl is a simple way to create a site that doesn't need a CMS and has a relatively simple structure. It doesn't have a database - you simply create the site structure in the filesystem and use Fizl tools and plugins to embed and template your site.

Fizl is in beta and has a few more features to be added (more templating features and more plugins), but take a look and see what's up!

## Installation

You shouldn't need to do anything for installation. Just put the files from the download into the directory you want your site to be in.

## Usage

### Site Structure

Using Fizl designed to be some simple shit. Each page on your site is a simple HTML document inside of the site folder. So, the index of your site is site/index.html and is callable by going to whatever your equivalent of http://www.example.com/ is.

Past that, you can either have HTML files for pages, or create folders for sub sections. Like so:

`site/about.html`
`site/about/index.html`

Both of these can be used to create a page that is accessible via:

`http://www.example.com/about`

So, you can do this:

`site/about/team.html`

and access it through this.

`http://www.example.com/about/team`

### Syntax

For content you can just write your own HTML or use something like Markdown or Textile for formatting (see the format plugin below), but functionality in Fizl is accessed via a tag syntax that you'll be very familiar with if you've ever used ExpressionEngine, MojoMotor, or PyroCMS.

`{variable}`

`{fiz:plugin param="value"}`

	{fiz:plugin param="value"}

	Content

	{\fiz:plugin}

### Variables

You can make your own variables very easily (see the Configs section below), but there are also a few made for you:

* segment_1 (Goes to segment_7. Returns the value of the URI segment)
* current_url
* site_url (Same as base_url but will contain the index.php if you haven't gotten ird of it)
* base_url

### Configs

Configs come from a simple config.txt file located at fizl/config.txt. There are some standard variables and then you can create your own by separating the variable name from the value with a colon (:):

`my_cool_var: 		This is the var!`

Now this variable is available via:

`{my_cool_var}`

### Embedding

Who doesn't like pieces of re-usable stuff in their pages? Am I right? To embed something, create an embed HTML document in your fizl/embeds and embed it like so:

`{embed file="example"}`

You can also pass variables to your embeds:

`{embed file="example" title="Sample"}`

The variable `{title}` is now available to the embed.

### Plugins

Plugins? We have plugins. They are accessed via a `{fiz:plugin:optional_function param="value"}` and can be used as a single tag or as a tag pair to modify the content between them.

#### Format

Fizl is a good application for having your content in markdown or textile. You can format your text like so:

`{fiz:format}

	# Welcome

	This is a cool page!

{/fiz:format}`

The default method is mardown, but you can change it by feeding it a param called "method" that has a value of "textile".

#### Asset

Some people like calling assets via plugins, so here you go. Very easy:

`{fiz:asset:img file="logo.gif" alt="Logo" id="logo"}`

`{fiz:asset:css file="main.css"}`

`{fiz:asset:js file="fun.js"}`

#### Navigation

Hate writing a whole ul list for your nav? Fizl has a nav plugin that allows you to create a navigation ul list with a simple syntax:

`{fiz:nav}
	
|Home
about|About
- about/team|Team
contact|Contact
	
{/fiz:nav}`

The current page's li will be given a class of "current".

### Templating

This needs to be expanded, but right now you can have a home.html and a sub.html template in your fizl/templates folder. home.html is used on the home page and sub.html for the sub.html page.

### Writing Your Own Plugins

Need your own functionality? Plugins are just CodeIgniter packages and you can put them in your fizl/plugins folder. The plugin calls a library of the same name as your plugin and should extend Plugin.

### FAQ

**This is confusing and scaring me. Why would anyone want to build a site like this?**

Sometimes you need something really simple but you don't want to make everything with HTML files and even a CMS is overkill. Sometimes it is just faster to have something in the filesystem with no database connectivity - especially if you don't have a client who need to edit things via a backend interface.

**Hey, didn't you steal this idea?**

Rick Ellis has a demo on his site of something called [FileDriver](http://rickellis.com/design/filedriver.html) which is where I got the idea to create Fizl (in combination with needing something really simple for a few small sites). In short, Fizl is very different - there is no emphasis on having txt files accessible far into the future and it uses a tag and plugin system instead of the FileDriver asset syntax. FD looks awesome but this is for a different application.

### Credits

Fizl is made by [Adam Fairholm](http://www.adamfairholm.com/).

Uses Dan Horrigan's [SimpleTags](http://hg.dhorrigan.com/simpletags/overview) library really heavily. Thanks Dan!
