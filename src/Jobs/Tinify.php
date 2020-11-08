<?php

namespace Jargoud\LaravelTinify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Jargoud\LaravelTinify\Facades\Tinify as TinifyFacade;
use Tinify\AccountException;

class Tinify implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var string|null
     */
    protected $targetPath;

    /**
     * Create a new job instance.
     *
     * @param string $filePath
     * @param string|null $targetPath
     */
    public function __construct(string $filePath, string $targetPath = null)
    {
        $this->filePath = $filePath;
        $this->targetPath = $targetPath ?? $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws AccountException
     */
    public function handle(): void
    {
        TinifyFacade::tinify($this->filePath, $this->targetPath);
    }
}
