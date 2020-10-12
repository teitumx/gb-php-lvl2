<?php

namespace app\controllers;

use app\services\RenderI;
use app\services\RenderServices;
use app\services\Request;
use app\main\Container;

abstract class Controller
{
    protected $action;
    protected $actionDefault = 'all';
    protected $renderer;
    protected $request;
    protected $container;

    public function __construct(Request $request, Container $container)
    {
        $this->container = $container;
        $this->request = $request;
    }

    public function run($action)
    {
        $this->action = $action;
        if (empty($action)) {
            $action = $this->actionDefault;
        }

        $action .= "Action";
        if (!method_exists($this, $action)) {
            return '404';
        }

        return $this->$action();
    }

    protected function getId()
    {
        return $this->request->getId();
    }

    protected function redirect($path = '', $msg = '')
    {
        if (!empty($msg)) {
            $_SESSION['msg'] = $msg;
        }

        if (empty($path)) {
            if (empty($_SERVER['HTTP_REFERER'])) {
                $path = '/';
            } else {
                $path = $_SERVER['HTTP_REFERER'];
            }
        }

        header('Location: ' . $path);
        return '';
    }

    protected function render($template, $params = [])
    {
        return $this->container->renderer->render($template, $params);
    }

    protected function sendJSON($data)
    {
        header('Content-Type: application/json');

        return json_encode($data);
    }
}
