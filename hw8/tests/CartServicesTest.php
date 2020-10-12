<?php

namespace app\tests;

use app\repositories\GoodRepository;
use app\services\CartServices;
use app\services\Request;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class CartServicesTest extends TestCase
{
    public function testAddEmptyId()
    {
        $mockRequest = $this->createMock(Request::class);

        $cartServices = new CartServices();
        $res = $cartServices->add(0, (new GoodRepository()), $mockRequest);

        $this->assertEquals("Not have ID", $res);
    }

    public function testAddEmptyGood()
    {
        $mockRequest = $this->createMock(Request::class);

        /** @var GoodRepository|MockObject $goodRepository */
        $goodRepository = $this->getMockBuilder(GoodRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $goodRepository->method('getOne')
            ->willReturn(false);

        $goodRepository
            ->expects(self::once())
            ->method('getOne');

        $cartServices = new CartServices();
        $res = $cartServices->add(1, $goodRepository, $mockRequest);

        $this->assertEquals('No good', $res);
    }

    /**
     * @dataProvider getDataForTestGetPrice
     */
    public function testGetPrice($priceReal, $tax, $expected)
    {
        $cartServices = new CartServices();
        $price = $cartServices->getPrice($priceReal, $tax);

        $this->assertEquals($expected, $price);
    }

    /**
     * @dataProvider getDataForTestGetPrice
     */
    public function testGetPrivatePrice($priceReal, $tax, $expected)
    {
        $method = new \ReflectionMethod('app\services\CartServices', 'getPrivatePrice');
        $method->setAccessible(true);

        $price = $method->invoke(new CartServices(), $priceReal, $tax);
        $this->assertEquals($expected, $price);
    }

    public function getDataForTestGetPrice()
    {
        return [
            [100, 0.5, 150],
            [100, 0.8, 180]
        ];
    }
}
