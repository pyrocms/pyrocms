<?php namespace Anomaly\S3StorageAdapterExtension;

use Anomaly\FilesModule\Disk\Contract\DiskInterface;
use Anomaly\FilesModule\FilesFilesystem;
use Anomaly\Streams\Platform\Application\Application;
use Aws\S3\S3Client;
use Illuminate\Filesystem\FilesystemManager;
use League\Flysystem\AwsS3v2\AwsS3Adapter;

/**
 * Class S3StorageAdapterFilesystem
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\S3StorageAdapterExtension
 */
class S3StorageAdapterFilesystem
{

    /**
     * Handle loading the filesystem.
     *
     * @param DiskInterface     $disk
     * @param FilesystemManager $manager
     * @param Application       $application
     */
    public function load(DiskInterface $disk, FilesystemManager $manager, Application $application)
    {
        $manager->extend(
            $disk->getSlug(),
            function () use ($disk, $application) {
                return new FilesFilesystem(
                    $disk, new AwsS3Adapter(
                    S3Client::factory(
                        array(
                            'key'    => 'AKIAJ6OR4KTLKPRF33PQ',
                            'secret' => '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',
                            'region' => 'us-west-2'
                        )
                    ), 'alctest', $disk->getSlug()
                )
                );
            }
        );
    }
}
