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
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected string $targetPath;

    public function __construct(protected string $filePath, string $targetPath = null)
    {
        $this->targetPath = $targetPath ?? $filePath;
    }

    /**
     * Execute the job.
     *
     * @throws AccountException
     */
    public function handle(): void
    {
        TinifyFacade::tinify($this->filePath, $this->targetPath);
    }
}
