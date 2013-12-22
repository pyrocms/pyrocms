<?php

namespace Sitemap\Sitemap;

use XMLWriter;

class SitemapEntry
{
    private $location;

    private $lastMod;

    private $priority;

    private $changeFreq;

    public function setLastMod($lastMod)
    {
        $this->lastMod = $lastMod;
    }

    public function getLastMod()
    {
        return $this->lastMod;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setChangeFreq($changeFreq)
    {
        $this->changeFreq = $changeFreq;
    }

    public function getChangeFreq()
    {
        return $this->changeFreq;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function getPriority()
    {
        return $this->priority;
    }
}