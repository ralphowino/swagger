<?php

namespace Ralphowino\Swagger\Generators;

class SwaggerApi extends SwaggerBase
{
    function __construct($name)
    {
        $this->name = $name;
        $this->filename = storage_path().'/swagger/apis/'.$name;
        $this->default= array(
            'resourcePath' => '/'.$name,
            'apiVersion' => '1.0.0',
            'swaggerVersion'=> '1.2',
            'apis'=> [],
        );
        return parent::__construct();
    }

    function getName()
    {
        return $this->name;
    }
} 