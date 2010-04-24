<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| BBCODE
| -------------------------------------------------------------------
| This file contains two arrays of bbcode for use with the bbcode helper.
| The first array is for buttons and the second is for parsing.
|
*/

$config['bbcodes'] = array(

//    name                onClick

    "b"            =>        "[removed]insert_bbcode('[b]', '[/b]');return(false)",
    "i"            =>        "[removed]insert_bbcode('[i]', '[/i]');return(false)",
    "u"            =>        "[removed]insert_bbcode('[u]', '[/u]');return(false)",
    "center"       =>        "[removed]insert_bbcode('[center]', '[/center]');return(false)",
    "right"        =>        "[removed]insert_bbcode('[right]', '[/right]');return(false)",
    "justify"      =>        "[removed]insert_bbcode('[justify]', '[/justify]');return(false)",
    "quote"        =>        "[removed]insert_bbcode('[q=AUTHOR]', '[/quote]');return(false)",
    "img"          =>        "[removed]insert_bbcode('[img]', '[/img]');return(false)",
    "url"          =>        "[removed]insert_bbcode('[url=]', '[/url]');return(false)",
    "email"        =>        "[removed]insert_bbcode('[email=]', '[/email]');return(false)"
        );

$config['bbcodes_to_parse'] = array(

//    regex                                            replacement                                    clean            loop

    "#\[base_url\]#i"                        =>        array(base_url(),                                    base_url(),        1),
    "#\[/\]#"                                =>        array("<hr width=\"100%\" size=\"1\" />",                "",                1),
    "#\[hr\]i#"                            =>        array("<hr width=\"100%\" size=\"1\" />",                "",                1),
    "#\[b\](.+)\[/b\]#isU"                    =>        array("<strong>$1</strong>",                            "",                1),
    "#\[i\](.+)\[/i\]#isU"                    =>        array("<em>$1</em>",                                "",                1),
    "#\[u\](.+)\[/u\]#isU"                    =>        array("<u>$1</u>",                                    "",                1),
    "#\[center\](.+)\[/center\]#isU"            =>        array("<div style=\"text-align: center\">$1</div>",        "",                1),
    "#\[right\](.+)\[/right\]#isU"            =>        array("<div style=\"text-align: right\">$1</div>",        "",                1),
    "#\[justify\](.+)\[/justify\]#isU"            =>        array("<div style=\"text-align: justify\">$1</div>",        "",                1),
    "#\[color=(.+)\](.+)\[/color\]#isU"        =>        array("<span style=\"color:$1\">$2</span>",                "",                1),
    "#\[size=([0-9]+)\](.+)\[/size\]#isU"        =>        array("<span style=\"font-size:$1px\">$2</span>",            "",                1),
    "#\[img\](.+)\[/img\]#isU"                =>        array("<img src=\"$1\" alt=\"\" border=\"0\" />",            "",                1),
    "#\[img=(.+)\]#isU"                        =>        array("<img src=\"$1\" alt=\"\" border=\"0\" />",            "",                1),
    "#\[email\](.+)\[/email\]#isU"            =>        array("<a href=\"mailto:$1\">$1</a>",                    "$1",            1),
    "#\[email=(.+)\](.+)\[/email\]#isU"        =>        array("<a href=\"mailto:$1\">$2</a>",                    "$1 ($2)",        1),
    "#\[url\](.+)\[/url\]#isU"                =>        array("<a href=\"$1\" target=\"_blank\">$1</a>",            "$1",            1),
    "#\[url=(.+)\](.+)\[/url\]#isU"            =>        array("<a href=\"$1\" target=\"_blank\">$2</a>",            "$1 ($2)",        1),
    "#\[list\](.+)\[/list\]#isU"                =>        array("<ul>$1</ul>",                                "\n$1\n",            1),
    "#\[\*\](.+)\[/\*\]#isU"                    =>        array("<li>$1</li>",                                " - $1\n",        1),
    "#\[quote\](.+)\[/quote\]#isU"                    =>        array("<blockquote>$1</blockquote>",                    "\"$1\"",            5),
    "#\[quote=(.+)\](.+)\[/quote\]#isU"                =>        array("<blockquote cite=\"$1\">$2</blockquote>",            "\"$2\" ($1)",        5),
        );