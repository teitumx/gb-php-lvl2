<?php

namespace app\main;

use Exception;

class Container
{
    protected $componentsData = [];
    protected $components = [];

    public function __construct(array $componentsData)
    {
        $this->componentsData = $componentsData;
    }

    public function __get($name) //получаем имя компонента
    {
        if (array_key_exists($name, $this->components)) {
            return $this->components[$name];
        }

        if (!array_key_exists($name, $this->componentsData)) {
            throw new \Exception('В компонентах не найден нужный класс' . $name);
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

        $this->components['name'] = $component;

        return $component;
    }
}
