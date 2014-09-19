<?php namespace Ralphowino\Swagger\Commands\Traits;

trait ApiGenerator
{
    function generateApi($name)
    {
         $this->swg->api($name);
    }


} 