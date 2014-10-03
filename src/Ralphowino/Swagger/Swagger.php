<?php namespace Ralphowino\Swagger;

use Ralphowino\Swagger\Generators\SwaggerApi;
use Ralphowino\Swagger\Generators\SwaggerResource;
use Ralphowino\Swagger\Generators\SwaggerModel;
use Ralphowino\Swagger\Generators\SwaggerOperation;
use Ralphowino\Swagger\Templates\RestfulOperations;

class Swagger
{
    function __construct()
    {
        return $this;
    }

    function api($path)
    {
        return new SwaggerApi($path);
    }

    function model($id)
    {
        return new SwaggerModel($id);
    }

    function resource($path)
    {
        return new SwaggerResource($path);
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
        if(file_exists($filepath))
        {
            return file_get_contents($filepath);
        }
        $filepath = storage_path() . '/swagger/resources/' . strtolower($id) . '.json';
            if(!file_exists($filepath))
                \App::abort(404);
        $api = json_decode(file_get_contents($filepath), true);
        if (isset($api['operations'])) {
            foreach ($api['operations'] as $operation)
            {
                $file = storage_path() . '/swagger/operations/' . $operation . '.json';
                if(is_readable($file))
                {
                    $operation = json_decode(file_get_contents($file), true);
                    $path = $operation['path'];
                    unset($operation['path']);
                    $api['apis'][] = ['path' => $path, 'operations' => [$operation]];
                    if(isset($operation['type']))
                        $api['attachmodels'][] = $operation['type'];
                    foreach($operation['parameters'] as $param)
                    {
                        if(!in_array($param['type'],['integer','string','number','boolean']) && isset($param['type']))
                            $api['attachmodels'][] = $param['type'];

                    }
                }

            }
            unset($api['operations']);
        }
        if(isset($api['attachmodels']))
        {
            foreach ($api['attachmodels'] as $key)
            {
                $model = storage_path() . '/swagger/models/' . strtolower($key) . '.json';
                if(is_readable($model))
                    $api['models'][$key] = json_decode(file_get_contents($model), true);
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


    public function config($path)
    {
        if(!isset($this->config))
        {
            $this->config = array_dot(require(__DIR__.'/Resources/config.php'));
        }
        return $this->config[$path];
    }

}