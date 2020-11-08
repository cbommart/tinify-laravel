<?php

namespace Jargoud\LaravelTinify\Services;

use InvalidArgumentException;
use Tinify\AccountException;
use Tinify\Result;
use Tinify\Source;
use Tinify\Tinify;

class TinifyService
{
    /**
     * @var string
     */
    protected $apikey;

    /**
     * @var Tinify
     */
    protected $client;

    /**
     * @var string
     */
    protected $s3_key;

    /**
     * @var string
     */
    protected $s3_secret;

    /**
     * @var string
     */
    protected $s3_region;

    /**
     * Get api key from env, fail if any are missing.
     * Instantiate API client and set api key.
     */
    public function __construct()
    {
        $this->apikey = config('tinify.apikey');
        if (!$this->apikey) {
            throw new InvalidArgumentException('Please set TINIFY_APIKEY environment variables.');
        }
        $this->client = new Tinify();
        $this->client->setKey($this->apikey);

        $this->s3_key = env('S3_KEY');
        $this->s3_secret = env('S3_SECRET');
        $this->s3_region = env('S3_REGION');
    }

    public function setKey(string $key): self
    {
        $this->client->setKey($key);
        return $this;
    }

    public function getCompressionCount(): int
    {
        return $this->client->getCompressionCount();
    }

    /**
     * @param string $string
     * @return Source
     * @throws AccountException
     */
    public function fromBuffer(string $string): Source
    {
        return Source::fromBuffer($string);
    }

    /**
     * @param string $sourcePath
     * @param string $bucket
     * @param string $destinationPath
     * @return Result|null
     * @throws AccountException
     */
    public function fileToS3(string $sourcePath, string $bucket, string $destinationPath): ?Result
    {
        if ($this->isS3Set()) {
            return Source::fromFile($sourcePath)->store([
                "service" => "s3",
                "aws_access_key_id" => $this->s3_key,
                "aws_secret_access_key" => $this->s3_secret,
                "region" => $this->s3_region,
                "path" => $bucket . $destinationPath,
            ]);
        }
        return null;
    }

    public function isS3Set(): bool
    {
        if ($this->s3_key && $this->s3_secret && $this->s3_region) {
            return true;
        }

        throw new InvalidArgumentException('Please set S3 environment variables.');
    }

    /**
     * @param string $string
     * @param string $bucket
     * @param string $path
     * @return Result|null
     * @throws AccountException
     */
    public function bufferToS3(string $string, string $bucket, string $path): ?Result
    {
        if ($this->isS3Set()) {
            return Source::fromBuffer($string)->store([
                "service" => "s3",
                "aws_access_key_id" => $this->s3_key,
                "aws_secret_access_key" => $this->s3_secret,
                "region" => $this->s3_region,
                "path" => $bucket . $path,
            ]);
        }
        return null;
    }

    /**
     * @param string $url
     * @param string $bucket
     * @param string $path
     * @return Result|null
     * @throws AccountException
     */
    public function urlToS3(string $url, string $bucket, string $path): ?Result
    {
        if ($this->isS3Set()) {
            return Source::fromUrl($url)->store([
                "service" => "s3",
                "aws_access_key_id" => $this->s3_key,
                "aws_secret_access_key" => $this->s3_secret,
                "region" => $this->s3_region,
                "path" => $bucket . $path,
            ]);
        }
        return null;
    }

    /**
     * @param string $from
     * @param string|null $to
     * @return false|int
     * @throws AccountException
     */
    public function tinify(string $from, string $to = null)
    {
        if (false !== filter_var($from, FILTER_VALIDATE_URL)) {
            $source = self::fromUrl($from);
        } else {
            $source = self::fromFile($from);
        }

        if (empty($to)) {
            $to = $from;
        }

        return $source->toFile($to);
    }

    /**
     * @param string $string
     * @return Source
     * @throws AccountException
     */
    public function fromUrl(string $string): Source
    {
        return Source::fromUrl($string);
    }

    /**
     * @param string $path
     * @return Source
     * @throws AccountException
     */
    public function fromFile(string $path): Source
    {
        return Source::fromFile($path);
    }
}
