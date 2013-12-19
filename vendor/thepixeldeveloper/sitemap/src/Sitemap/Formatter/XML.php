<?php

namespace Sitemap\Formatter;

use Sitemap\Formatter;
use XMLWriter;

abstract class XML implements Formatter
{
    abstract protected function collectionName();

    abstract protected function entryWrapper();

    public function render($sitemaps)
    {
        $writer = new XMLWriter;
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElementNs(null, $this->collectionName(), 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($sitemaps as $sitemap) {
            $writer->startElement($this->entryWrapper());
            $writer->writeRaw($this->writeElement('loc', $sitemap->getLocation()));
            $writer->writeRaw($this->writeElement('lastmod', $sitemap->getLastMod()));
            $writer->writeRaw($this->writeElement('changefreq', $sitemap->getChangeFreq()));
            $writer->writeRaw($this->writeElement('priority', $sitemap->getPriority()));
            $writer->endElement();
        }

        $writer->endElement();
        return $writer->flush();
    }

    private function writeElement($name, $value = null)
    {
        $writer = new XMLWriter;
        $writer->openMemory();

        if (!empty($value)) {
            $writer->writeElement($name, $value);
        }

        return $writer->flush();
    }
}