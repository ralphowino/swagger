<?php

namespace Ralphowino\Swagger\Generators;

class SwaggerApi extends SwaggerBase
{
    function __construct($name)
    {
        $this->filename = storage_path().'/swagger/apis/'.$name;
        $this->default= array(
            'resourcePath' => '/'.$name,
            'apiVersion' => '1.0.0',
            'swaggerVersion'=> '1.2',
            'apis'=> [],
            'operations' => [],
        );
        return parent::__construct();
    }
} 