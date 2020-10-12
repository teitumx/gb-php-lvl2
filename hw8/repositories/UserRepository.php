<?php

namespace app\repositories;

use app\entities\User;

class UserRepository extends Repository
{
    protected function getTableName(): string
    {
        return 'users';
    }

    protected function getEntityName(): string
    {
        return User::class;
    }

    public function getUserByLogin($login)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE login = :login ";
        $params = [':login' => $login];
        return $this->getDB()->getObject($sql, $this->getEntityName(), $params);
    }
}
