<?php
namespace Incoded\Core\Router;

use Incoded\Core\Request\Request;

class Router
{
    private
        $request,
        $controller,
        $method = 'error404',
        $is_404 = true,
        $route  = null,
        $routes = array(
            'home'                     => array('uri' => '/', 'controller' => 'website', 'method' => 'index'),
            'by_method'                => array('uri' => '/:method', 'controller' => 'website'),
            'by_controller_and_method' => array('uri' => '/:controller/:method'),
        );

    public function __construct(Request $request)
    {
        $this->request = $request;
        
        // get configured routes
        $routes = @include INCODED_APP . DS . 'config' . DS . 'routes.php';

        if (!is_array($routes)) {
            throw new \Exception('Router config is invalid.');
        }

        $this->routes = array_merge($routes, $this->routes);

        $this->findRoute();
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function is404()
    {
        return $this->is_404;
    }

    private function findRoute()
    {
        $requested_uri = $this->request->getUri();

        foreach ($this->getRoutes() as $route => $properties)
        {
            $uri = $properties['uri'];

            if (isset($properties['controller'])) {
                $uri = str_replace(':controller', $properties['controller'], $uri);
            }

            if (isset($properties['method'])) {
                $uri = str_replace(':method', $properties['method'], $uri);
            }

            // if (strpos($uri, ':method') !== false) {
            //     $uri = str_replace(':method', $properties['method'], $uri);
            // }

            if ($uri == $requested_uri) {
                $this->route  = array($route => $properties);
                $this->method = isset($properties['method']) ? $properties['method'] : ltrim($this->requested_uri, '/');
                $this->is_404 = false;
                break;
            }

            if ($route == 'default') {
                $this->route  = array($route => $properties);
                $this->method = ltrim(str_replace(':method', ltrim($this->requested_uri, '/'), $properties['uri']), '/');
                $this->is_404 = false;
                break;
            }
        }

        // if ($this->is_404) {
        //     $this->method = 'error404';
        // }
    }

    public function redirect($url = '')
    {
        header('Location: /' . $url);
    }
}