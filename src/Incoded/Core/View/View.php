<?php
namespace Incoded\Core\View;

class View
{
    public
        $vars = array();

    private
        $config        = array(),
        $title         = '',
        $layout        = false,
        $template      = false,
        $config_path,
        $layout_path,
        $template_path;

    public function __construct($path)
    {
        $this->config_path   = $path . DS . 'Config' . DS;
        $this->layout_path   = $path . DS . 'Layout' . DS;
        $this->template_path = $path . DS . 'View' . DS;

        // get configuration
        if (!file_exists($this->config_path . 'view.php')) {
            throw new \Exception('View config does not exist');
        }

        $this->config = include $this->config_path . 'view.php';

        // get layout
        if (!file_exists($this->layout_path . $this->config['layout'] . '.php')) {
            throw new \Exception('Layout "' . $this->config['layout'] . '" does not exist');
        }

        $this->setLayout($this->config['layout']);

        // get page title
        if (isset($this->config['title'])) {
            $this->setTitle($this->config['title']);
        }
    }

    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setLayout($layout = false)
    {
        if (!$layout) return true;

        $this->layout = $layout;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function show()
    {
        if ($this->layout) {
            return $this->showLayout();
        }

        return $this->showTemplate();
    }

    public function showLayout()
    {
        if (!file_exists($this->layout_path . $this->layout . '.php')) {
            // layout does not exist
            throw new \Exception('Layout "' . $this->layout . '" does not exist');
        }

        return $this->includeFile($this->layout_path . $this->layout . '.php');
    }

    public function showTemplate()
    {
        if (!file_exists($this->template_path . $this->template . '.php')) {
            if ($this->template == 'error404') {
                return include INCODED_SRC . 'Incoded' . DS . 'Public' . DS . 'error404.php';
            } else {
                // template does not exist
                throw new \Exception('Template "' . $this->template . '" does not exist');
            }
        }

        return $this->includeFile($this->template_path . $this->template . '.php');
    }

    public function includeTemplate($template)
    {
        if (!file_exists($this->template_path . $template . '.php')) {
            // template does not exist
            throw new \Exception('Template "' . $template . '" does not exist');
        }

        return $this->includeFile($this->template_path . $template . '.php');
    }

    private function includeFile($path)
    {
        foreach ($this->vars as $key => $value)
        {
            $$key = $value;
        }

        return include $path;
    }

    public function showAssets($type)
    {
        $types = array(
            'javascripts',
            'stylesheets',
        );

        if (!in_array($type, $types)) {
            // asset type does not exist
            throw new \Exception('ERROR: Asset type "' . $type . '" does not exist');
        }

        $assets = $this->config[$type];

        // load assets
        foreach ($assets as $asset)
        {
            switch ($type)
            {
                case 'javascripts':
                    echo '<script src="' . $asset . '"></script>' . "\n";
                    break;
                
                case 'stylesheets':
                    echo '<link rel="stylesheet" type="text/css" media="screen" href="' . $asset . '" />' . "\n";
                    break;
            }
        }
    }

    public function addAsset($path, $type)
    {
        $types = array(
            'javascripts',
            'stylesheets',
        );

        if (!in_array($type, $types)) {
            // asset type does not exist
            throw new \Exception('ERROR: Asset type "' . $type . '" does not exist');
        }

        array_push($this->config[$type], $path);
    }
}