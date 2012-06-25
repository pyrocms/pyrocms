Lex
===

Lex is a lightweight template parser.


_Lex is released under the MIT License and is Copyrighted 2011 Dan Horrigan._

Basic Usage
===========

Including Lex
-------------

Lex includes a basic autoloader to load it's classes.

    include 'lib/Lex/Autoloader.php';
    Lex_Autoloader::register();

Using Lex
---------

Basic parsing of a file:

    $parser = new Lex_Parser();
    $template = $parser->parse(file_get_contents('template.lex'), $data);

You can also set the Scope Glue (see "Scope Glue" under Syntax below):

    $parser = new Lex_Parser();
    $parser->scope_glue(':');
    $template = $parser->parse(file_get_contents('template.lex'), $data);
	
To allow noparse extractions to accumulate so they don't get parsed by a later call to the parser set cumulative_noparse to true:

    $parser = new Lex_Parser();
    $parser->cumulative_noparse(true);
    $template = $parser->parse(file_get_contents('template.lex'), $data);
	// Second parse on the same text somewhere else in your app
	$template = $parser->parse($template, $data);
	// Now that all parsing is done we inject the contents between the {{ noparse }} tags back into the template text
	Lex_Parser::inject_noparse($template);

If you only want to parse a data array and not worry about callback tags or comments, you can do use the `parse_variables()` method:

    $parser = new Lex_Parser();
    $template = $parser->parse_variables(file_get_contents('template.lex'), $data);


### PHP in Templates

By default PHP is encoded, and not executed.  This is for security reasons.  However, you may at times want to enable it.  To do that simply send `true` as the fourth parameter to your `parse()` call.

    $parser = new Lex_Parser();
    $template = $parser->parse(file_get_contents('template.lex'), $data, $callback, true);

Syntax
======

General
-------

All Lex code is delimeted by double curly braces (`{{ }}`).  These delimeters were chosen to reduce the chance of conflicts with JavaScript and CSS.

Here is an example of some Lex template code:

    Hello, {{name}}


Scope Glue
----------

Scope Glue is/are the character(s) used by Lex to trigger a scope change.  A scope change is what happens when, for instance, you are accessing a nested variable inside and array/object, or when scoping a custom callback tag.

By default a dot (`.`) is used as the Scope Glue, although you can select any character(s).


Whitespace
----------

Whitespace before or after the delimeters is allowed, however, in certain cases, whitespace within the tag is prohibited (explained in the following sections).

**Some valid examples:**

    {{ name }}
    {{name }}
    {{ name}}
    {{  name  }}
    {{
      name
    }}

**Some invalid examples:**

    {{ na me }}
    { {name} }


Comments
--------

You can add comments to your templates by wrapping the text in `{{# #}}`.

**Example**

    {{# This will not be parsed or shown in the resulting HTML #}}

    {{#
        They can be multi-line too.
    #}}

Prevent Parsing
---------------

You can prevent the parser from parsing blocks of code by wrapping it in `{{ noparse }}{{ /noparse }}` tags.

**Example**

    {{ noparse }}
        Hello, {{ name }}!
    {{ /noparse }}

Variable Tags
-------------

When dealing with variables, you can: access single variables, access deeply nested variables inside arrays/objects, and loop over an array.  You can even loop over nested arrays.

### Simple Variable Tags

For our basic examples, lets assume you have the following array of variables (sent to the parser):

    array(
        'title'     => 'Lex is Awesome!',
        'name'      => 'World',
        'real_name' => array(
            'first' => 'Lex',
            'last'  => 'Luther',
        )
    )

**Basic Example:**

	{{# Parsed: Hello, World! #}}
    Hello, {{ name }}!

	{{# Parsed: <h1>Lex is Awesome!</h1> #}}
    <h1>{{ title }}</h1>

	{{# Parsed: My real name is Lex Luther!</h1> #}}
    My real name is {{ real_name.first }} {{ real_name.last }}

The `{{ real_name.first }}` and `{{ real_name.last }}` tags check if `real_name` exists, then check if `first` and `last` respectively exist inside the `real_name` array/object then returns it.

### Looped Variable Tags

Looped Variable tags are just like Simple Variable tags, except they correspond to an array of arrays/objects, which is looped over.

A Looped Variable tag is a closed tag which wraps the looped content.  The closing tag must match the opening tag exactly, except it must be prefixed with a forward slash (`/`).  There can be **no** whitespace between the forward slash and the tag name (whitespace before the forward slash is allowed).

**Valid Example:**

    {{ projects }} Some Content Here {{ /projects }}

**Invalid Example:**

    {{ projects }} Some Content Here {{/ projects }}

The looped content is what is contained between the opening and closing tags.  This content is looped through and output for every item in the looped array.

When in a Looped Tag you have access to any sub-variables for the current element in the loop.

In the following example, let's assume you have the following array/object of variables:

    array(
        'title'     => 'Current Projects',
        'projects'  => array(
            array(
                'name' => 'Acme Site',
                'assignees' => array(
                    array('name' => 'Dan'),
                    array('name' => 'Phil'),
                ),
            ),
            array(
                'name' => 'Lex',
                'contributors' => array(
                    array('name' => 'Dan'),
                    array('name' => 'Ziggy'),
					array('name' => 'Jerel')
                ),
            ),
        ),
    )

In the template, we will want to display the title, followed by a list of projects and their assignees.

    <h1>{{ title }}</h1>
    {{ projects }}
        <h3>{{ name }}</h3>
        <h4>Assignees</h4>
        <ul>
        {{ assignees }}
            <li>{{ name }}</li>
        {{ /assignees }}
        </ul>
    {{ /projects }}

As you can see inside each project element we have access to that project's assignees.  You can also see that you can loop over sub-values, exactly like you can any other array.

Conditionals
-------------

Conditionals in Lex are simple and easy to use.  It allows for the standard `if`, `elseif`, and `else`.

All `if` blocks must be closed with either a `{{ /if }}` or `{{ endif }}` tag.

Variables inside of if Conditionals, do not, and should not, use the Tag delimeters (it will cause wierd issues with your output).

A Conditional can contain any Comparison Operators you would do in PHP (`==`, `!=`, `===`, `!==`, `>`, `<`, `<=`, `>=`).  You can also use any of the Logical Operators (`!`, `||`, `&&`, `and`, `or`).

**Examples**

    {{ if show_name }}
        <p>My name is {{real_name.first}} {{real_name.last}}</p>
    {{ endif }}

    {{ if user.group == 'admin' }}
        <p>You are an Admin!</p>
    {{ elseif user.group == 'user' }}
        <p>You are a normal User.</p>
    {{ else }}
        <p>I don't know what you are.</p>
    {{ endif }}

    {{ if show_real_name }}
        <p>My name is {{real_name.first}} {{real_name.last}}</p>
    {{ else }}
        <p>My name is John Doe</p>
    {{ endif }}


### Callback Tags in Conditionals

Using a callback tag in a conditional is simple.  Use it just like any other variable except for one exception.  When you need to provide attributes for the callback tag, you are required to surround the tag with a ***single*** set of braces (you can optionally use them for all callback tags).

**Examples**

    {{ if user.logged_in }} {{ endif }}

    {{ if user.logged_in and {user.is_group group="admin"} }} {{ endif }}


Callback Tags
-------------

Callback tags allow you to have tags with attributes that get sent through a callback.  This makes it easy to create a nice plugin system.

Here is an example

    {{ template.partial name="navigation" }}

You can also close the tag to make it a **Callback Block**:

    {{ template.partial name="navigation" }}
    {{ /template.partial }}

Note that attributes are not required.  When no attributes are given, the tag will first be checked to see if it is a data variable, and then execute it as a callback.

    {{ template.partial }}

### The Callback

The callback can be any valid PHP callable.  It is sent to the `parse()` method as the third parameter:

    $parser->parse(file_get_contents('template.lex'), $data, 'my_callback');

The callback must accept the 3 parameters below (in this order):

    $name - The name of the callback tag (it would be "template.partial" in the above examples)
    $attributes - An associative array of the attributes set
    $content - If it the tag is a block tag, it will be the content contained, else a blank string

The callback must also return a string, which will replace the tag in the content.

**Example**

    function my_callback($name, $attributes, $content)
    {
        // Do something useful
        return $result;
    }

Recursive Callback Blocks
-------------

The recursive callback tag allows you to loop through a child's element with the same output as the main block. It is triggered
by using the ***recursive*** keyword along with the array key name. The two words must be surrounded by asterisks as shown in the example below.

**Example**
	
	function my_callback($name, $attributes, $content)
	{
		$data = array(
				'url' 		=> 'url_1', 
				'title' 	=> 'First Title',
				'children'	=> array(
					array(
						'url' 		=> 'url_2',
						'title'		=> 'Second Title',
						'children' 	=> array(
							array(
								'url' 	=> 'url_3',
								'title'	=> 'Third Title'
							)
						)
					),
					array(
						'url'		=> 'url_4',
						'title'		=> 'Fourth Title',
						'children'	=> array(
							array(
								'url' 	=> 'url_5',
								'title'	=> 'Fifth Title'
							)
						)
					)
				)
		);
		
		$parser = new Lex_Parser();
		return $parser->parse($content, $data);
	}
	

In the template set it up as shown below. If `children` is not empty Lex will
parse the contents between the `{{ navigation }}` tags again for each of `children`'s arrays.
The resulting text will then be inserted in place of `{{ *recursive children* }}`. This can be done many levels deep.
	
	<ul>
		{{ navigation }}
			<li><a href="{{ url }}">{{ title }}</a>
				{{ if children }}
					<ul>
						{{ *recursive children* }}
					</ul>
				{{ endif }}
			</li>
		{{ /navigation }}
	</ul>


**Result**

	<ul>
		<li><a href="url_1">First Title</a>
			<ul>
				<li><a href="url_2">Second Title</a>
					<ul>
						<li><a href="url_3">Third Title</a></li>
					</ul>
				</li>
				
				<li><a href="url_4">Fourth Title</a>
					<ul>
						<li><a href="url_5">Fifth Title</a></li>
					</ul>
				</li>
			</ul>
		</li>
	</ul>
