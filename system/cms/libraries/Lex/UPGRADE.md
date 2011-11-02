Upgrading to Lex
================

**This may change, as Lex is still under heavy development**

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

Callback Tags in Conditionals
-----------------------------

Callback Tags in conditionals are allowed, however, are frowned upon.  If a Callback Tag is required in a conditional, it would probable be better rewritten as a Variable.

Something like this still works:

    {{ if '{{theme.options option="layout"}}' == 'fixed' }}

However, it would probably be better used as a Variable:

    {{ if theme.options.layout == 'fixed' }}


Variables in Conditionals
-------------------------

Variables in conditionals do not, and should not, be wrapped in delimeters.

Likewise, if the variable returns a string, you do not have to surround it with quotes.

**Old style:**

    {if '{{name}}' == 'Dan'}

**New style:**

    {{ if name == 'Dan' }}

_Note that you can use the whitespace in conditional tags as well._

