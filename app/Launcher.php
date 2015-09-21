<?php
namespace App;

use App\Autoloader as Autoloader;
use Incoded\Core\Model\Model as Model;
use Incoded\Core\View\View as View;

class Launcher
{
    private
        $model       = null,
        $controller  = null,
        $settings    = array(),

        // core and additional classes
        $add_classes = array(),
        $classes     = array(
            '\Incoded\Core\Session\Session',
            '\Incoded\Core\Request\Request',
            '\Incoded\Core\Router\Router',
            '\Incoded\Core\Database\DBLayer',
        );

    public function __construct()
    {
        $settings_path = INCODED_APP . DS . 'config' . DS . 'settings.php';

        // load settings
        if (file_exists($settings_path)) {
            $settings = @include $settings_path;

            if (!is_array($settings)) {
                throw new \Exception('Settings is invalid.');
            }

            $this->settings = $settings;
        }

        // load autoloader class
        require_once INCODED_APP . DS . 'Autoloader.php';

        try {

            $this->setModel();      // load core classes
            $this->setResources();  // load additional classes
            $this->initiate();      // launch all

        } catch (\Exception $e) {

            throw new \Exception($e->getMessage(), 1);

            return $this->show500($e->getMessage());
        }
    }

    public function setModel()
    {
        // register autoloader
        $autoloader = new Autoloader;
        spl_autoload_register(array($autoloader, 'load'));

        // load core
        $this->model = new Model;

        foreach ($this->classes as $class)
        {
            $chunks   = explode('\\', $class);
            $instance = strtolower(end($chunks));

            // echo '<pre>class: ' . $class . '</pre>';
            // echo '<pre>instance: ' . $instance . '</pre>';

            if ($class == '\Incoded\Core\Router\Router') {
                $this->model->$instance = new $class($this->model->request);
                continue;
            }

            $this->model->$instance = new $class;
        }
    }

    public function setResources()
    {
        foreach ($this->settings['resources'] as $namespace)
        {
            $path = INCODED_SRC . str_replace('\\', DS, $namespace);

            // register resource autoloader
            $autoloader = new Autoloader;
            $autoloader->setNamespace($namespace);
            $autoloader->setPath($path);
            spl_autoload_register(array($autoloader, 'load'));
        }
    }

    public function initiate()
    {
        $namespace          = 'Humanity\Notifications';
        $resource_path      = INCODED_RESOURCES . 'Humanity/Notifications';
        $controller_name    = '\Humanity\Notifications\Controller\Website';
        $controller_method  = $this->model->router->getMethod();

        // register resource autoloader
        $autoloader = new Autoloader;
        $autoloader->setNamespace($namespace);
        $autoloader->setPath(INCODED_RESOURCES);
        // $autoloader->setExcludes(array('Config', 'Layout', 'View'));
        spl_autoload_register(array($autoloader, 'load'));

        // create controller object
        $controller = new $controller_name;

        // check controller method
        if (!method_exists($controller, $controller_method) || !is_callable(array($controller, $controller_method)))
        {
            throw new \Exception ('Controller "' . $controller_name . '" method "' . $controller_method . '" does not exist');
        }

        // create view object
        $view = new View($resource_path);

        // inject model into controller
        $controller->setModel($this->model);

        // inject view into controller
        $controller->setView($view);

        // execute method "before"
        $controller->__before($this->model->request);

        // execute requested method
        $controller->$controller_method($this->model->request);

        // show view
        $controller->showView();

        // execute method "after"
        $controller->__after($this->model->request);

        $this->controller = $controller;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function is401()
    {
        return $this->is_401;
    }

    public function is403()
    {
        return $this->is_403;
    }

    public function is404()
    {
        return $this->is_404;
    }

    public function show500($error)
    {
        return include INCODED_SRC . 'Incoded' . DS . 'Public' . DS . 'error500.php';
    }

    public function register($namespaces = array())
    {

    }
}