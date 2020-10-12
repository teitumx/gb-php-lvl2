<?php

namespace app\controllers;

use app\entities\Good;
use app\repositories\GoodRepository;

class GoodController extends Controller
{
    public function allAction()
    {
        $goods = $this->container->goodRepository->getAll();
        return $this->render(
            'goodAll',
            ['goods' => $goods]
        );
    }

    public function oneAction()
    {
        $id = $this->getId();
        $good = $this->container->goodRepository->getOne($id);
        return $this->render('goodOne', ['good' => $good,]);
    }

    public function updateAction()
    {
        /**@var Good $good */
        $good = (new GoodRepository())->getOne(4);
        $good->login = 'newGood1';
        (new GoodRepository())->save($good);
    }

    public function addAction()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return $this->render('goodAdd');
        }

        $good = new Good();
        $good->name = $_POST['name'];
        $good->price = $_POST['price'];
        $good->info = $_POST['info'];
        (new GoodRepository())->save($good);

        header('Location: /');
        return '';
    }

    public function insertAction()
    {
        /**@var Good $good */
        $good = new Good;
        $good->name = 'newGood';
        $good->price = 'qwery';
        $good->info = 'goodNew';
        (new GoodRepository())->save($good);
    }
}
