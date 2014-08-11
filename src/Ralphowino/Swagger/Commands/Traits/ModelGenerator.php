<?php namespace Ralphowino\Swagger\Commands\Traits;

trait ModelGenerator
{
    function generateModel($name)
    {
        $model = $this->swg->model(studly_case($name));
        $this->addModelProperties($model);
    }

    function addModelProperties($model)
    {
        $id = $this->ask('Enter name of property [Press enter to quit]:');
        if (is_null($id)) return;
        $property[$id]['type'] = strtolower($this->ask('Enter type of property ' . $id . ' [Default: String]:', 'string'));
        $model->addProperty($property);
        $this->info('Added property ' . $id . ' to model');
        $this->addModelProperties($model);
    }
} 