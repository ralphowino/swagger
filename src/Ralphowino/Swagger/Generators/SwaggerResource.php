<?php

namespace Ralphowino\Swagger\Generators;

use Illuminate\Support\Str;

class SwaggerResource extends SwaggerBase
{
    function __construct($nickname)
    {
        $this->filename = storage_path().'/swagger/resources/'.Str::snake($nickname);
        $this->default= array(
            'basePath' => url(\Config::get('swagger::api.route'))
        );
        return parent::__construct();
    }

    function getName()
    {
        return str_replace('.json','',basename($this->filename));
    }
} 