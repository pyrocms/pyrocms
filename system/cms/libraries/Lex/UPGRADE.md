Upgrading to Lex
================

If you are upgrading your templates from 'Tags' or 'SimpleTags', please read below.

This is not a list of all of the new features of Lex, it is simply a guide for upgrading your templates to work with Lex.

New Delimeters
--------------

The delimeters in Lex are two (2) braces(`{{ }}`), not one (1) (`{ }`).  You will need to change all of your tags to use the new style.

Example:

    {{name}}

Whitespace in Tags
------------------

You can now put whitespace in your tags before and after the delimeters. ***The whitespace is optional.***

Example

    {{ name }}

Scope Glue
----------

Scope glue is a new concept in Lex.  The Scope glue is the character used to separate, you guessed it, scopes.  A scope is what was called a 'segment' in Tags.

By default the Scope Glue is a dot (`.`).  However, that can be changed.  Please see the README for more detailed information.


Variables in Conditionals
-------------------------

Variables in conditionals do not, and should not, be wrapped in delimeters.

Likewise, if the variable returns a string, you do not have to surround it with quotes.

**Old style:**

    {if '{{name}}' == 'Dan'}

**New style:**

    {{ if name == 'Dan' }}

_Note that you can use the whitespace in conditional tags as well._

Callback Tags in Conditionals
-----------------------------

Using a callback tag in a conditional is simple.  Use it just like any other variable except for one exception.  When you need to provide attributes for the callback tag, you are required to surround the tag with a ***single*** set of braces (you can optionally use them for all callback tags).

**Examples**

    {{ if user.logged_in }} {{ endif }}

    {{ if user.logged_in and {user.is_group group="admin"} }} {{ endif }}

