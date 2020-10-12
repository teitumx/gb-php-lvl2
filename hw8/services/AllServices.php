<?php


namespace app\services;


use app\main\Container;

class AllServices
{
    public $container;
    public function setContainer($container)
    {
        $this->container = $container;
    }
}
