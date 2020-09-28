<?php

namespace app\controllers;

use app\entities\User;
use app\repositories\UserRepository;

class UserController extends Controller
{
    public function allAction()
    {
        $users = (new UserRepository())->getAll();
        return $this->renderer->render("userAll", ['users' => $users]);
    }

    public function oneAction()
    {
        $id = $this->getId();
        $user = (new UserRepository())->getOne($id);
        return $this->renderer->render(
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
        $user = (new UserRepository())->getOne(4);
        $user->login = 'newUser1';
        $user->save($user);
    }

    public function addAction()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return $this->renderer->render('userAdd');
        }

        $user = new User();
        $user->password = $_POST['password'];
        $user->login = $_POST['login'];
        $user->name = $_POST['name'];
        (new UserRepository())->save($user);

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
        (new UserRepository())->save($user);
    }
}
