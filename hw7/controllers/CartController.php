<?php

namespace app\controllers;

use app\entities\Good;
use app\repositories\GoodRepository;
use app\services\CartServices;

class CartController extends Controller
{
    const BASKET_NAME = 'goods';

    protected $actionDefault = 'index';

    public function indexAction()
    {

        if (!empty($_SESSION['goods'])) {
            $goods = $_SESSION['goods'];
            return $this->render(
                'cart',
                ['goods' => $goods]
            );
        }

        return $this->render('cart');
    }

    public function addAction()
    {
        $msg = $this->container->cartServices->add(
            $this->getId(),
            $this->container->goodRepository,
            $this->request
        );

        return $this->redirect('', $msg);
    }

    public function fakeAddAction()
    {
        $msg = $this->container->cartServices->add(
            $this->getId(),
            $this->container->goodRepository,
            $this->request
        );

        $this->sendJSON([
            'test' => 'test1',
            'msg' => $msg,
        ]);
    }
}
