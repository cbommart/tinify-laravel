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
     * Create a new job instance.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws AccountException
     */
    public function handle(): void
    {
        TinifyFacade::tinify($this->filePath);
    }
}
