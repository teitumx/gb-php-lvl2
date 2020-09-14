<?php

namespace models\Good;

class Good extends Model
{
    use TCalc;

    public $id;
    public $name;
    public $price;
    public $info;

    protected function getTableName():string
    {
        return 'goods'; 
    }

    public function getAll()
    {
        $this->echoTest();
        return parent::getAll();
    }


};
