<?php
namespace Ralphowino\Swagger\Generators;

use Ralphowino\Swagger\Swagger;

class SwaggerApi extends SwaggerBase
{
    function __construct($name)
    {
        $this->swg = new Swagger();
        $this->name = $name;
        $this->filename = storage_path().'/swagger/apis/'.$name;
        $this->default= array(
            'resourcePath' => '/'.$name,
            'apiVersion' => \Config::get('swagger::api.version','1.0.0'),
            'swaggerVersion'=> $this->swg->config('version'),
            'apis'=> [],
        );
        return parent::__construct();
    }

    function getName()
    {
        return $this->name;
    }
}