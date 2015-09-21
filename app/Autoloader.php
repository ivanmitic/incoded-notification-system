<?php
namespace App;

class Autoloader
{
    public
        $path      = INCODED_SRC,
        $namespace = 'Incoded\Core',
        $excluded  = array(
            'Config',
            'Controller',
            'Layout',
            'View',
        );

    public function load($class_name)
    {
        $file_name  = $this->getPath();
        $namespace  = $this->getNamespace();
        $class_name = ltrim($class_name, '\\'); // remove backslash from the beginning of class name

        if ($last_ns_pos = strripos($class_name, '\\')) {
            $namespace  = substr($class_name, 0, $last_ns_pos);
            $class_name = substr($class_name, $last_ns_pos + 1);
        }

        $file_name .= str_replace('\\', DS, $namespace) . DS;
        $file_name .= str_replace('_', DS, $class_name) . '.php';

        if (is_readable($file_name)) require $file_name;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }
}