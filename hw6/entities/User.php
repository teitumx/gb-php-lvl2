<?php

namespace app\entities;

class User extends Entity
{
    public $id;
    public $name;
    public $login;
    public $password;

    // protected static function getTableName(): string
    // {
    //     return 'users';
    // }
};
