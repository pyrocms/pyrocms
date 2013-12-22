<?php

namespace Sitemap;

use Sitemap\Sitemap\SitemapEntry;
use Sitemap\Formatter\XML\URLSet;

class URLSetTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicXMLWriter()
    {
        $basic1 = new SitemapEntry;
        $basic1->setPriority(0.8);
        $basic1->setChangeFreq('monthly');
        $basic1->setLastMod('2005-01-01');
        $basic1->setLocation('http://www.example.com/');

        $basic2 = new SitemapEntry;
        $basic2->setChangeFreq('weekly');
        $basic2->setLocation('http://www.example.com/catalog?item=12&desc=vacation_hawaii');

        $urlsetCollection = new Collection;
        $urlsetCollection->addSitemap($basic1);
        $urlsetCollection->addSitemap($basic2);
        $urlsetCollection->setFormatter(new URLSet);

        $this->assertXmlStringEqualsXmlFile(__DIR__.'/../controls/basic.xml', (string) $urlsetCollection->output());
    }
}
