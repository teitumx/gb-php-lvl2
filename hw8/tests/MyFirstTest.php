<?php

namespace app\tests;

use PHPUnit\Framework\TestCase;

class MyFirstTest extends TestCase
{
    /**
     *@dataProvider getDataForFirstTest
     */
    public function testFirst($a, $b, $expected)
    {
        $c = $a + $b;
        $this->assertEquals($expected, $c);

        $c = 5 + 6;
        $this->assertEquals($c, 11);
    }

    public function testSecond()
    {
        $this->assertFalse(false);
        $this->assertTrue(true);
        $this->assertEquals(10, 10);
    }

    public function getDataForFirstTest()
    {
        return [
            [5, 5, 10],
            [5, 6, 11],
        ];
    }
}
