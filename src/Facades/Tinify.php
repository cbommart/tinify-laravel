<?php

namespace Jargoud\LaravelTinify\Facades;

use Illuminate\Support\Facades\Facade;
use Jargoud\LaravelTinify\Services\TinifyService;

/**
 * Class Tinify
 *
 * @package Jargoud\LaravelTinify\Facades
 * @mixin TinifyService
 */
class Tinify extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tinify';
    }
}
