<?php

namespace Snowfire\Beautymail;

use Illuminate\Support\Facades\Facade;

class BeautymailFacade extends Facade
{
    /**
     * The name of the binding in the IoC container.
     *
     * @return class-string
     */
    protected static function getFacadeAccessor(): string
    {
        return Beautymail::class;
    }
}
