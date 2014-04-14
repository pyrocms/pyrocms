<?php namespace Pyro\Module\Templates\Collection;

use Pyro\Module\Streams\Entry\EntryCollection;

class TemplateEntryCollection extends EntryCollection
{
    /**
     * Find by lang
     *
     * @param $lang
     * @return TemplateEntryCollection
     */
    public function findByLang($lang)
    {
        foreach ($this->items as $item) {
            if ($item->lang == $lang) {
                return $item;
            }
        }

        if ($lang !== 'en') {
            return $this->findByLang('en');
        } else {
            return false;
        }
    }
}
