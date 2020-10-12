<?php

namespace app\services;

use app\entities\Good;
use app\repositories\GoodRepository;

class CartServices extends AllServices
{
    const BASKET_NAME = 'goods';

    public function add($id, GoodRepository $goodRepository, Request $request)
    {
        if (empty($id)) {
            return 'Not have ID';
        }

        $good = $goodRepository->getOne($id);
        if (empty($good)) {
            return 'No good';
        }

        $goods = $request->getSession(self::BASKET_NAME);

        //если массив сессии с этим id пустой, то записываем новый товар
        if (empty($goods[$id])) {
            $goods[$id] = [
                'name' => $good->name,
                'count' => 1,
                'price' => $good->price,
            ];
            $request->setSession(self::BASKET_NAME, $goods);
            return 'Товар добавлен';
        }
        $goods[$id]['count']++;
        $goods[$id]['price'] = $goods[$id]['count'] * $good->price;
        $request->setSession(self::BASKET_NAME, $goods);

        return 'Кол-во измененно';
    }

    public function getPrice($priceReal, $tax)
    {
        return $priceReal + ($priceReal * $tax);
    }

    protected function getPrivatePrice($priceReal, $tax)
    {
        return $priceReal + ($priceReal * $tax);
    }

    public function getCart()
    {
        return $this->container->request->getSession(self::BASKET_NAME);
    }

    public function cleanCart()
    {
        unset($_SESSION[self::BASKET_NAME]);
    }
}
