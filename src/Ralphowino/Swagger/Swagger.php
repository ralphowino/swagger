<?php

namespace Ralphowino\Swagger;
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
            $temp = new RestfulOperations($entity);
            $temp->generate();
            $this->api('index')->apis([['path'=>\Str::plural($entity)]]);
        }
    }

    function get($id)
    {
        $api = json_decode(file_get_contents(storage_path() . '/swagger/apis/' . strtolower($id) . '.json'), true);
        if (isset($api['operations'])) {
            foreach ($api['operations'] as $operation)
            {
                $operation = json_decode(file_get_contents(storage_path() . '/swagger/operations/' . $operation . '.json'), true);
                $path = $operation['path'];
                unset($operation['path']);
                $api['apis'][] = ['path' => $path, 'operations' => [$operation] ];
            }
            unset($api['operations']);
        }
        return json_encode($api);
    }

} 