<?php

namespace Sitemap;

use Sitemap\Sitemap\SitemapEntry;

class Collection
{
    private $sitemaps = array();

    private $formatter;

    public function addSitemap(SitemapEntry $sitemap)
    {
        $this->sitemaps[serialize($sitemap)] = $sitemap;
    }

    public function setFormatter(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function output()
    {
        return $this->formatter->render($this->sitemaps);
    }
}
