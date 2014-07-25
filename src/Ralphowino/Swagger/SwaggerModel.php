<?php
/**
 * Created by PhpStorm.
 * User: TOSH
 * Date: 7/19/2014
 * Time: 6:58 AM
 */

namespace Ralphowino\Swagger;


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