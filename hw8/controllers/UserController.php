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
        $user = $this->container->userRepository->getOne($id);
        return $this->render('userOne', ['user' => $user]);
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
    public function loginFormAction()
    {
        return $this->render('auth');
    }
    public function loginAction()
    {
        try {
            $this->container->userService->login($_POST['login'], $_POST['password'], $this->container->userRepository);
            $this->redirect('/good');
        } catch (\Exception $exc) {
            $this->redirect('', $exc->getMessage());
        }
    }
    public function logoutAction()
    {
        $this->container->userService->logout();
        $this->redirect('/user/loginForm');
    }
}
