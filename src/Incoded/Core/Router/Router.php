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
            'home'                     => array('uri' => '/',        'controller' => 'website', 'method' => 'index'),
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
        $routes        = $this->getRoutes();
        $requested_uri = ltrim($this->request->getUri(), '/');
        $requested_uri_chunks       = explode('/', $requested_uri);
        $requested_uri_chunks_count = count($requested_uri_chunks);

        // try to match requested uri with default routes
        if ( $requested_uri == '' ) {
            // home route
            $this->route  = array('home' => $routes['home']);
            $this->method = $routes['home']['method'];
            $this->is_404 = false;

            // add method and controller into the request as get params
            $this->request->setParam('method', $this->method);
            $this->request->setParam('controller', $routes['home']['controller']);

            return true;
        }
        else if ( $requested_uri_chunks_count == 1 ) {
            // by_method route
            $this->route  = array('by_method' => $routes['by_method']);
            $this->method = $requested_uri_chunks[0];
            $this->is_404 = false;

            // add method and controller into the request as get params
            $this->request->setParam('method', $this->method);
            $this->request->setParam('controller', $routes['by_method']['controller']);

            return true;
        }

        // try to match requested uri with defined routes and
        // collect get parameters for request
        foreach ($routes as $route => $properties)
        {
            $uri              = ltrim($properties['uri'], '/');
            $uri_chunks       = explode('/', $uri);
            $uri_chunks_count = count($uri_chunks);

            // skip route if it's different by number of chunks
            if ( $requested_uri_chunks_count != $uri_chunks_count ) continue;

            foreach ($uri_chunks as $uri_chunk_index => $uri_chunk)
            {
                if ( ':' != substr($uri_chunk, 0, 1) ) {
                    // skip route if chunk is different then requested uri chunk
                    if ( $uri_chunk != $requested_uri_chunks[$uri_chunk_index] ) continue 2;
                }
                else {
                    // add variable into request
                    $this->request->setParam(ltrim($uri_chunk, ':'), $requested_uri_chunks[$uri_chunk_index]);
                }
            }

            // route found
            $this->route  = array($route => $properties);
            $this->method = $properties['method'];
            $this->is_404 = false;

            // add method and controller into the request as get params
            $this->request->setParam('method', $this->method);
            $this->request->setParam('controller', $properties['controller']);

            break;
        }

        return false;
    }

    public function redirect($url = '')
    {
        header('Location: /' . $url);
    }
}