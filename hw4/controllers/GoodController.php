<?php

namespace app\controllers;

use app\models\Good;

class GoodController
{
    protected $action;
    protected $actionDefault = 'all';

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

    public function allAction()
    {
        $goods = Good::getAll();
        return $this->render("goodAll", ['goods' => $goods]);
    }

    public function oneAction()
    {
        $id = $this->getId();
        $good = Good::getOne($id);
        return $this->render(
            "userOne",
            [
                'user' => $good,
                'title' => $good->name,
            ]
        );
    }

    public function updateAction()
    {
        /**@var User $user */
        $user = Good::getOne(4);
        $user->login = 'newGood';
        $user->save();
    }

    public function addAction()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return $this->render('goodAdd');
        }

        $user = new Good();
        $user->name = $_POST['name'];
        $user->price = $_POST['price'];
        $user->info = $_POST['info'];
        $user->save();

        header('Location: /');
        return '';
    }

    public function insertAction()
    {
        /**@var User $user */
        $user = new Good;
        $user->name = 'newGood';
        $user->price = '1000';
        $user->info = 'Info about this good';
        $user->save();
    }

    public function render($template, $params = [])
    {
        $content = $this->renderTmpl($template, $params);

        $title = 'My Shop';
        if (!empty($params['title'])) {
            $title = $params['title'];
        }

        return $this->renderTmpl(
            'main',
            [
                'content' => $content,
                'title' => $title,
            ]
        );
    }

    public function renderTmpl($template, $params = [])
    {
        ob_start();
        extract($params);
        include dirname(__DIR__) . '/views/layouts/' . $template . '.php';
        return ob_get_clean();
    }

    protected function getId()
    {
        if (empty($_GET['id'])) {
            return 'Такого товара нет';
        }

        return (int)$_GET['id'];
    }
}
