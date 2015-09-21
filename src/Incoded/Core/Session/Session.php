<?php
namespace Incoded\Core\Session;

class Session
{
    private
        $params = array();

    public function __construct()
    {
        $this->params = $_SESSION;
    }

    public function getAll()
    {
        return $this->params;
    }

    public function set($name, $value, $namespace = null)
    {
        if ($namespace) {
            $this->params[$namespace][$name] = $value;
            $_SESSION[$namespace][$name] = $value;
        } else {
            $this->params[$name] = $value;
            $_SESSION[$name] = $value;
        }
    }

    public function get($name, $namespace = null)
    {
        if ($namespace) {
            return $this->has($name, $namespace) ? $this->params[$namespace][$name] : null;
        }

        return $this->has($name, $namespace) ? $this->params[$name] : null;
    }

    public function has($name, $namespace = null)
    {
        if ($namespace) {
            return isset($this->params[$namespace]) && isset($this->params[$namespace][$name]);
        }

        return isset($this->params[$name]);
    }

    public function remove($name, $namespace = null)
    {
        if ($namespace) {
            unset($this->params[$namespace][$name]);
            unset($_SESSION[$namespace][$name]);
        } else {
            unset($this->params[$name]);
            unset($_SESSION[$name]);
        }
    }
}