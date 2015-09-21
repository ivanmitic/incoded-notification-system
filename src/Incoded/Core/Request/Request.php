<?php
namespace Incoded\Core\Request;

class Request
{
    public
        $params = array(
            'GET'  => array(),
            'POST' => array()
        );

    private
        $ssl    = false,
        $method = 'GET',
        $host   = null,
        $script = 'index.php',
        $query  = '',
        $home   = '',
        $uri    = '';

    public function __construct()
    {
        // get server and request parameters
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
        $this->host   = $_SERVER['SERVER_NAME'];
        $this->script = basename($_SERVER['SCRIPT_NAME']);
        $this->query  = $_SERVER['QUERY_STRING'];
        $this->home   = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']), '/');
        $this->uri    = str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);

        if ($this->home != '') {
            $this->uri = substr($this->uri, strlen('/' . $this->home));
        }

        // get and post parameters
        $this->params['GET']  = $_GET;
        $this->params['POST'] = $_POST;
    }

    public function get($index)
    {
        return $this->getParam($index, 'GET');
    }

    public function post($index)
    {
        return $this->getParam($index, 'POST');
    }

    private function getParam($index, $method)
    {
        return isset($this->params[$method][$index]) ? trim($this->params[$method][$index]) : null;
    }

    public function setParam($index, $value, $method = 'GET')
    {
        $this->params[$method][$index] = $value;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getHome()
    {
        return $this->home;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setSsl($ssl = true)
    {
        $this->ssl = $ssl ? true : false;
    }

    public function getSsl()
    {
        return $this->ssl ? true : false;
    }

    public function getUrl($absolute = false)
    {
        if (!$absolute) {
            return '/' . $this->home . $this->uri;
        }

        return ($this->getSsl() ? 'https://' : 'http://') . $this->host . '/' . $this->home . $this->uri;
    }

    public function getHomeUrl($absolute = false)
    {
        if (!$absolute) {
            return '/' . $this->home;
        }

        return ($this->getSsl() ? 'https://' : 'http://') . $this->host . '/' . $this->home;
    }

    public function isXmlHttpRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}