<?php

namespace Sitemap;

use Sitemap\Sitemap\SitemapEntry;
use Sitemap\Formatter\XML\SitemapIndex;

class SitemapIndexTest extends \PHPUnit_Framework_TestCase
{
    public function testDuplicateEntries()
    {
        $sitemap1 = new SitemapEntry;
        $sitemap1->setLocation('http://www.example.com/sitemap1.xml.gz');
        $sitemap1->setLastMod('2004-10-01T18:23:17+00:00');

        // Duplicate entries start.
        $sitemap2 = new SitemapEntry;
        $sitemap2->setLocation('http://www.example.com/sitemap2.xml.gz');
        $sitemap2->setLastMod('2005-01-01');

        $sitemap3 = new SitemapEntry;
        $sitemap3->setLocation('http://www.example.com/sitemap2.xml.gz');
        $sitemap3->setLastMod('2005-01-01');
        // Duplicate entries end.

        $index = new Collection;
        $index->addSitemap($sitemap1);
        $index->addSitemap($sitemap2);
        $index->addSitemap($sitemap3);
        $index->setFormatter(new SitemapIndex);

        $this->assertXmlStringEqualsXmlFile(__DIR__.'/../controls/index.xml', (string) $index->output());
    }
}
