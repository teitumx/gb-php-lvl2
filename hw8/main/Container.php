<?php

namespace app\main;

use app\repositories\GoodRepository;
use app\repositories\OrderRepository;
use app\repositories\UserRepository;
use app\services\BasketService;
use app\services\DB;
use app\services\GoodService;
use app\services\OrderService;
use app\services\Request;
use app\services\TwigRenderServices;
use app\services\UserService;

class Container
{
    protected $componentsData = [];
    protected $components = [];

    public function __construct(array $componentsData)
    {
        $this->componentsData = $componentsData;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->components)) {
            return $this->components[$name];
        }

        if (!array_key_exists($name, $this->componentsData)) {
            throw new \Exception('В компонентах не определен класс ' . $name);
        }

        $className = $this->componentsData[$name]['class'];
        if (!empty($this->componentsData[$name]['config'])) {
            $config = $this->componentsData[$name]['config'];
            $component = new $className($config);
        } else {
            $component = new $className();
        }

        if (method_exists($component, 'setContainer')) {
            $component->setContainer($this);
        }

        $this->components[$name] = $component;

        return $component;
    }
}
