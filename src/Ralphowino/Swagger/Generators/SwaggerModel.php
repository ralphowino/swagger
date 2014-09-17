<?php
namespace Ralphowino\Swagger\Generators;


class SwaggerModel extends SwaggerBase
{
    protected  $default = ['properties'=>[]];

    function __construct($name)
    {
        $this->filename = storage_path().'/swagger/models/'.strtolower($name);
        $this->default['id'] = $name;
        return parent::__construct();
    }

    function addProperty(Array $property)
    {
        $this->addContent('properties',$property);
        return $this;
    }
}