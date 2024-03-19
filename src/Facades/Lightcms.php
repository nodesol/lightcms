<?php

namespace Nodesol\Lightcms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nodesol\Lightcms\Lightcms
 */
class Lightcms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Nodesol\Lightcms\Lightcms::class;
    }
}
