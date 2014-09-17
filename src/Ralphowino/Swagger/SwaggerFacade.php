<?php

namespace Ralphowino\Swagger;

use Illuminate\Support\Facades\Facade;

class SwaggerFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'ralphowino.swagger';
    }

} 