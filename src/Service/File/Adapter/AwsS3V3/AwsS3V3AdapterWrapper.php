<?php

namespace AnyCloud\Service\File\Adapter\AwsS3V3;

use Aws\S3\S3ClientInterface;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Config;
use League\Flysystem\PathPrefixer;

class AwsS3V3AdapterWrapper extends AwsS3V3Adapter
{
    private ?PathPrefixer $prefixer;

    public function __construct(
        private S3ClientInterface $client,
        private array $config,
    ) {
        parent::__construct($client, $config['bucket']);

        $pathPrefix = $this->config['public_path_prefix'];
        if ($pathPrefix) {
            $this->prefixer = new PathPrefixer($pathPrefix, '/');
        } else {
            $this->prefixer = null;
        }
    }

    public function publicUrl(string $path, Config $cnf): string
    {
        if ($this->prefixer) {
            return $this->prefixer->prefixPath($path);
        }

        return parent::publicUrl($path, $cnf);
    }
}
