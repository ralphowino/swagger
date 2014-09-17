<?php namespace Ralphowino\Swagger\Commands\Traits;

trait ResourceGenerator
{
    function generateResource($name)
    {
        $resource = $this->swg->resource(strtolower($name));
        $this->addResourceProperties($resource);
        $this->swg->api('index')->apis(array(array('path'=>'/'.strtolower($name),'description'=>ucfirst($name))));
    }

    function addResourceProperties($resource)
    {
        $operation = $this->ask('Enter name of operation [Press enter to quit]:');
        if (is_null($operation)) return;
        $resource->operations($operation);
        $this->info('Added ' . $operation . ' to '.$resource->getName());
        $this->addResourceProperties($resource);
    }
} 