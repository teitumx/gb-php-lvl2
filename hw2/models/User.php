<?php

namespace models\User;

class User extends Model
{
    public $id;
    public $name;
    public $login;
    public $password;

    protected function getTableName():string
    {
        return 'users'; 
    }

};
