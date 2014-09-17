<?php

namespace Ralphowino\Swagger\Generators;


class SwaggerBase
{
    protected $filename;

    protected $content = [];

    protected $default = [];

    function __construct()
    {
        $this->filename = $this->filename.'.json';
        $this->retrieve();
        return $this;
    }

    function __call($node, $content)
    {
        foreach($content as $value)
        {
            $this->addContent($node, $value);
        }
        $this->save();
        return $this;
    }

    protected function addContent($node, $value)
    {
        if (is_array($value)) {
            $this->addArray($node, $value);
        } elseif (is_string($value)) {
            $this->addString($node, $value);
        }
        $this->save();
    }

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

    protected function addString($node, $value)
    {
        if (isset($this->content[$node]) && is_array($this->content[$node]))
        {
            array_push($this->content[$node], $value);
        } else {
            $this->content[$node] = $value;
        }
    }

    protected function save()
    {
        $this->prepareFile();
        file_put_contents($this->filename, json_encode($this->content));
    }

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