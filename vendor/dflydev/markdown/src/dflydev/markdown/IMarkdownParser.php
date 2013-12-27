<?php

/*
 * This file is a part of the PHP Markdown library.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\markdown;

interface IMarkdownParser {

    /**
     * Transform Markdown text to HTML.
     * @param string $text
     * @return string
     */
    public function transformMarkdown($text);

}