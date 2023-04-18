<?php

namespace Jargoud\LaravelTinify\Facades;

use Illuminate\Support\Facades\Facade;
use Jargoud\LaravelTinify\Services\TinifyService;

/**
 * @mixin TinifyService
 */
class Tinify extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'tinify';
    }
}
