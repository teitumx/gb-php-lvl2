<?php

namespace app\models;

class Good extends Model
{
    use TCalc;

    public $id;
    public $name;
    public $price;
    public $info;

    /*
     *
     */

    protected static function getTableName(): string
    {
        return 'goods';
    }
};
