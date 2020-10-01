<?php

namespace app\controllers;

use app\entities\User;
use app\repositories\UserRepository;

class UserController extends Controller
{
    public function allAction()
    {
        $users = $this->container->userRepository->getAll();
        return $this->render(
            'userAll',
            ['users' => $users]
        );
    }

    public function oneAction()
    {
        $id = $this->getId();
        $good = $this->container->userRepository->getOne($id);
        return $this->render('userOne', ['user' => $good,]);
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
        (new UserRepository())->save($user);

        header('Location: /');
        return '';
    }
}
