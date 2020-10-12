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
        $basket = $this->container->cartServices->getCart();
        return $this->render('cart', ['goods' => $basket]);
    }
    public function cleanAction()
    {
        $this->container->cartServices->cleanCart();
        $this->redirect('/cart/index');
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

    public function makeOrderAction()
    {
        try {
            $basket = $this->container->cartServices->getCart();
            $this->container->orderServices->makeOrder($basket);
            $this->redirect('\order\all');
        } catch (\Exception $exc) {
            $this->redirect('', $exc->getMessage());
        }
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
