<?php
namespace Incoded\Core\Controller;

use Incoded\Core\View\View;
use Incoded\Core\Request\Request;

abstract class Controller
{
    public
        $view,
        $template;

    private
        $model;

    public function __set($index, $value)
    {
        $this->view->vars[$index] = $value;
    }

    public function __before(Request $request)
    {
        $this->request = $request;
    }

    public function __after(Request $request) {}

    abstract public function index(Request $request);

    public function error404(Request $request)
    {
        $this->show('error404');
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function showView()
    {
        $this->view->show();
    }

    public function show($template, $layout = false)
    {
        $this->view->setTemplate($template);
        $this->view->setLayout($layout);
    }

    public function setView($view)
    {
        $this->view = $view;
    }

    public function getView()
    {
        return $this->view;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }
}