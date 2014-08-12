<?php namespace Ralphowino\Swagger;

use Ralphowino\Swagger\Generators\SwaggerApi;
use Ralphowino\Swagger\Generators\SwaggerModel;
use Ralphowino\Swagger\Generators\SwaggerOperation;
use Ralphowino\Swagger\Templates\RestfulOperations;

class Swagger
{
    function __construct()
    {
        return $this;
    }

    function model($id)
    {
        return new SwaggerModel($id);
    }

    function api($path)
    {
        return new SwaggerApi($path);
    }

    function operation($nickname)
    {
        return new SwaggerOperation($nickname);
    }

    function generateEntities($entities)
    {
        foreach($entities as $entity)
        {
            $this->generateEntity($entity);
        }
    }

    function get($id)
    {
        $filepath = storage_path() . '/swagger/apis/' . strtolower($id) . '.json';
        if(!file_exists($filepath))
            \App::error(404);
        $api = json_decode(file_get_contents($filepath), true);
        if (isset($api['operations'])) {
            foreach ($api['operations'] as $operation)
            {
                $operation = json_decode(file_get_contents(storage_path() . '/swagger/operations/' . $operation . '.json'), true);
                $path = $operation['path'];
                unset($operation['path']);
                $api['apis'][] = ['path' => $path, 'operations' => [$operation]];
                $api['attachmodels'][] = $operation['type'];
            }
            unset($api['operations']);
        }
        if(isset($api['attachmodels']))
        {
            foreach ($api['attachmodels'] as $key)
            {
                $api['models'][$key] = json_decode(file_get_contents(storage_path() . '/swagger/models/' . strtolower($key) . '.json'), true);
            }
            unset($api['attachmodels']);
        }

        return json_encode($api);
    }

    /**
     * @param $entity
     */
    protected function generateEntity($entity)
    {
        $temp = new RestfulOperations($entity);
        $temp->generate();
        $this->api('index')->apis([['path' => \Str::plural($entity)]]);
    }

} 