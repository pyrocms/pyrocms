<?php

namespace Sitemap\Formatter\XML;

class SitemapIndex extends \Sitemap\Formatter\XML
{
    protected function collectionName()
    {
        return 'sitemapindex';
    }

    protected function entryWrapper()
    {
        return 'sitemap';
    }
}