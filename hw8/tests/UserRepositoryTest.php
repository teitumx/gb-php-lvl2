<?php

namespace app\tests;

use app\repositories\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    public function testGetTableName()
    {
        $method = new \ReflectionMethod('app\repositories\UserRepository', 'getTableName');
        $method->setAccessible(true);

        $tableName = $method->invoke(new UserRepository());
        $this->assertEquals("users", $tableName);
    }

    public function testGetEntityName()
    {
        $method = new \ReflectionMethod('app\repositories\UserRepository', 'getEntityName');
        $method->setAccessible(true);

        $tableName = $method->invoke(new UserRepository());
        $this->assertEquals('app\entities\User', $tableName);
    }
}
