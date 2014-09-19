<?php

namespace Ralphowino\Swagger\Generators;


use Ralphowino\Swagger\Swagger;

/**
 * Class SwaggerBase
 * @package Ralphowino\Swagger\Generators
 */
class SwaggerBase
{

    protected $swg;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array
     */
    protected $content = [];

    /**
     * @var array
     */
    protected $default = [];

    /**
     * @param Swagger $swg
     */
    function __construct()
    {
        $this->filename = $this->filename.'.json';
        $this->retrieve();
        return $this;
    }

    /**
     * @param $node
     * @param $content
     *
     * @return $this
     */
    function __call($node, $content)
    {
        foreach($content as $value)
        {
            $this->addContent($node, $value);
        }
        $this->save();
        return $this;
    }

    /**
     * @param $node
     * @param $value
     */
    protected function addContent($node, $value)
    {
        if (is_array($value)) {
            $this->addArray($node, $value);
        } elseif (is_string($value)) {
            $this->addString($node, $value);
        }
        $this->save();
    }

    /**
     * @param $node
     * @param $value
     */
    protected function addArray($node, $value)
    {
        if (!isset($this->content[$node]))
            $this->content[$node] = [];
        if(array_keys($value) !== range(0, count($value) - 1))
        {
            $this->content[$node] = array_merge($this->content[$node], $value);
        }
        else
        {
            foreach($value as $element)
            if(!in_array($element, $this->content[$node]))
            {
                array_push($this->content[$node], $element);
            }
        }
    }

    /**
     * @param $node
     * @param $value
     */
    protected function addString($node, $value)
    {
        if (isset($this->content[$node]) && is_array($this->content[$node]))
        {
            array_push($this->content[$node], $value);
        } else {
            $this->content[$node] = $value;
        }
    }

    /**
     * @throws \Exception
     */
    protected function save()
    {
        $this->prepareFile();
        file_put_contents($this->filename, json_encode($this->content, JSON_PRETTY_PRINT));
    }

    /**
     * @throws \Exception
     */
    protected function prepareFile()
    {
        if (is_null($this->filename))
            throw new \Exception('Filename not specified: ' . get_called_class());
        if (is_dir($this->filename))
            throw new \Exception('Filename is directory: ' . $this->filename);
        $dir = dirname($this->filename);
        if (!is_dir($dir))
            mkdir($dir, 0777, true);
    }

    /**
     *
     */
    protected function retrieve()
    {
        $content = array();
        if (file_exists($this->filename))
        {
            $content = json_decode(file_get_contents($this->filename), true);
            if(is_null($content)) $content = array();
        }
        $this->content = array_merge($this->default, $content);
    }
}