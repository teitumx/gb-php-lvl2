<?php

namespace app\controllers;

use app\services\RenderI;
use app\services\RenderServices;
use app\services\Request;

abstract class Controller
{
    protected $action;
    protected $actionDefault = 'all';
    protected $renderer;
    protected $request;

    public function __construct(RenderI $renderer, Request $request)
    {
        $this->renderer = $renderer;
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
}
