<?php namespace Pyro\Module\Variables\Model;

use Pyro\Module\Streams_core\EntryDataModel;

class VariablesVariableEntryModel extends EntryDataModel
{
    /**
     * The stream slug
     * @var string
     */
    protected $streamSlug = 'variables';

    /**
     * The stream namespace
     * @var string
     */
    protected $streamNamespace = 'variables';
}