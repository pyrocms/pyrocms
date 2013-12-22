<?php

namespace Sitemap\Formatter\XML;

class URLSet extends \Sitemap\Formatter\XML
{
    protected function collectionName()
    {
        return 'urlset';
    }

    protected function entryWrapper()
    {
        return 'url';
    }
}