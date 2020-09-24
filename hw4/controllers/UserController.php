<?php

namespace app\controllers;

use app\models\User;

class UserController
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
        $users = User::getAll();
        return $this->render("userAll", ['users' => $users]);
    }

    public function oneAction()
    {
        $id = $this->getId();
        $user = User::getOne($id);
        return $this->render(
            "userOne",
            [
                'user' => $user,
                'title' => $user->login,
            ]
        );
    }

    public function updateAction()
    {
        /**@var User $user */
        $user = User::getOne(4);
        $user->login = 'newUser1';
        $user->save();
    }

    public function addAction()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return $this->render('userAdd');
        }

        $user = new User();
        $user->password = $_POST['password'];
        $user->login = $_POST['login'];
        $user->name = $_POST['name'];
        $user->save();

        header('Location: /');
        return '';
    }

    public function insertAction()
    {
        /**@var User $user */
        $user = new User;
        $user->login = 'newUser';
        $user->password = 'qwery';
        $user->name = 'userNew';
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
            return 'Такого пользователя нет';
        }

        return (int)$_GET['id'];
    }
}
