<?php

namespace app\services;

use Exception;

class Request
{
    protected $requestString;
    protected $controllerName = '';
    protected $actionName = '';
    protected $params =
    [
        'get' => [],
        'post' => [],
    ];

    public function __construct()
    {
        $this->requestString = $_SERVER['REQUEST_URI'];
        $this->parseRequest(); //заполнение controller и  action
        $this->fillParams(); //заполнение params
    }

    protected function parseRequest()
    {
        //отлавливание ошибок
        // try {
        //     if (empty($_GET['id'])) {
        //         throw new \Exception('Первый необязательный параметр сообщение ошибки', 100);
        //     }
        //     if (!empty($_GET['id']) && 100) {
        //         throw new \Exception('Первый необязательный параметр сообщение ошибки', 200);
        //     }
        // } catch (\Exception $exception) {
        //     $code = $exception->getCode();
        //     if ($code == 100) {
        //         var_dump($exception->getMessage());
        //     }
        //     var_dump($exception->getTrace());
        // } finally {
        //     var_dump('Выполнится в любом случае');
        // }



        $pattern = "#(?P<controller>\w+)[/]?(?P<action>\w+)?[/]?[?]?(?P<params>.*)#ui";

        if (preg_match_all($pattern, $this->requestString, $matches)) {
            if (!empty($matches['controller'][0])) {
                $this->controllerName = $matches['controller'][0];
            }
            if (!empty($matches['action'][0])) {
                $this->actionName = $matches['action'][0];
            }
        }
    }

    protected function fillParams()
    {
        $this->params = [
            'get' => $_GET,
            "post" => $_POST,
        ];
    }

    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function getId()
    {
        if (empty($this->params['get']['id'])) {
            return 'Такого товара нет';
        }

        return (int)$this->params['get']['id'];
    }
}
