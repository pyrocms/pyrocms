<?php namespace Anomaly\S3StorageAdapterExtension;

use Anomaly\FilesModule\Adapter\StorageAdapterExtension;

/**
 * Class S3StorageAdapterExtension
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\S3StorageAdapterExtension
 */
class S3StorageAdapterExtension extends StorageAdapterExtension
{

    /**
     * This module provides the Amazon S3
     * storage adapter for the files module.
     *
     * @var string
     */
    protected $provides = 'anomaly.module.files::storage_adapter.s3';

}
