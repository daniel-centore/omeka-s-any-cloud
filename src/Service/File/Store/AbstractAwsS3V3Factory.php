<?php

namespace AnyCloud\Service\File\Store;

use AnyCloud\Service\File\Adapter\AwsS3V3\AwsS3V3AdapterWrapper;
use Aws\S3\S3Client;
use League\Flysystem\FilesystemAdapter;

abstract class AbstractAwsS3V3Factory extends AbstractFlysystemFactory
{
    protected function getFilesystemAdapter(array $config): FilesystemAdapter
    {
        $options = [
            'credentials' => [
                'key'    => $config['key'],
                'secret' => $config['secret'] ?? $config['secret_key'],
            ],
            'region'   => $config['region'],
            'endpoint' => $config['endpoint'],
            'version'  => 'latest',
        ];
        $client = new S3Client($options);
        $adapter = new AwsS3V3AdapterWrapper($client, $config);

        return $adapter;
    }
}
