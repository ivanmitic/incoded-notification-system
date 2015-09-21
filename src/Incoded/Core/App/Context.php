<?php
namespace Incoded\Core;

use Incoded\Core\Session\Session;
use Incoded\Core\Request\Request;
use Incoded\Core\Router\Router;

class Context
{
    private
        $path     = null,
        $layout   = 'default',
        $action   = 'index',
        $template = 'index',
        $title    = '',
        $session  = null,
        $request  = null,
        $router   = null;

    public function __construct($path)
    {
        $this->setPath($path);
    }

    private function setPath($path)
    {
        $this->path = $path;
    }

    private function getPath()
    {
        return $this->path;
    }

    public function getContentPath()
    {
        return sprintf('%sapps' . DS . 'default' . DS . 'View' . DS, $this->path);
    }

    public function getLayoutPath()
    {
        return sprintf('%sapps' . DS . 'default' . DS . 'Layout' . DS . '%s', $this->path, $this->getLayout());
    }

    public function getActionPath()
    {
        return sprintf('%sapps' . DS . 'default' . DS . 'actions' . DS . '%s', $this->path, $this->getAction());
    }

    public function getTemplatePath()
    {
        return sprintf('%sapps' . DS . 'default' . DS . 'View' . DS . '%s', $this->path, $this->getTemplate());
    }

    public function setLayout($layout = null)
    {
        $this->layout = $layout;

        if (!file_exists($this->getLayoutPath())) {
            throw new \Exception('Layout "{'.$this->getLayout().'}" does not exists.');
        }
    }

    public function getLayout()
    {
        return $this->layout ? sprintf('%s.php', $this->layout) : null; 
    }

    public function setAction($action = null)
    {
        $this->action = $action;

        if (!file_exists($this->getActionPath())) {
            echo '<pre>';
            throw new \Exception('Action "{'.$this->getAction().'}" does not exists.');
            echo '</pre>';
        }
    }

    public function getAction()
    {
        return $this->action ? sprintf('%s.php', $this->action) : null; 
    }

    public function setTemplate($template = null)
    {
        $this->template = $template;

        if (!file_exists($this->getTemplatePath())) {
            echo '<pre>';
            throw new \Exception('Template "{$'.$this->getTemplate().'}" does not exists.');
            echo '</pre>';
        }
    }

    public function getTemplate()
    {
        return $this->template ? sprintf('%s.php', $this->template) : null; 
    }

    public function setTitle($title = '')
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title; 
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    public function getSession()
    {
        return $this->session; 
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request; 
    }

    public function setRouter(Router $router)
    {
        $this->router = $router;
        
        $this->setAction($this->router->getAction());
        $this->setTemplate($this->router->getAction());
    }

    public function getRouter()
    {
        return $this->router; 
    }

}

?>