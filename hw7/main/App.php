<?php

namespace app\main;

use app\traits\SingletonTrait;
use app\services\Request;

class App
{
    use SingletonTrait;

    protected $config;
    protected $container;

    public static function call()
    {
        return static::getInstance();
    }


    public function run($config)
    {
        $this->container = new Container($config['components']);
        $this->config = $config;
        $this->runController();
    }

    private function runController()
    {
        $request = new \app\services\Request();

        $controllerName = $this->config['defaultController'];

        if (!empty($request->getActionName())) {
            $controllerName = $request->getControllerName();
        }

        $controllerClass = 'app\\controllers\\' . ucfirst($controllerName) . 'Controller';

        if (class_exists($controllerClass)) {
            $renderer = new \app\services\RenderTwigServices();
            $controller = new $controllerClass($request, $this->container);
            echo $controller->run($request->getActionName());
        } else {
            echo '404';
        }
    }
}
