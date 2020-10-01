<?php

namespace app\controllers;

class AuthController extends Controller
{
    private $login;
    private $password;

    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return $this->render('auth');
        }
    }

    public function loginAction()
    {
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            $this->login = $_POST['login'];
            $this->password = $_POST['password'];
        } else {
            echo 'Заполнены не все поля!';
        }
    }
}
