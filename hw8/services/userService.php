<?php

namespace app\services;

use app\repositories\UserRepository;
use app\services\RenderServices;

class UserService extends AllServices
{
    public function login(string $login, string $password, UserRepository $userRepository)
    {
        $user = $userRepository->getUserByLogin($login);
        if (empty($user)) {
            echo 'Пользователь не найден';
        }
        if ($user->password != $password) {
            echo 'Неверный пароль';
        }
        $_SESSION['user'] = $user;
    }
    public function getCurrentUser()
    {
        return empty($_SESSION['user']) ? null : $_SESSION['user'];
    }
    public function logout()
    {
        $_SESSION['user'] = null;
    }
}
