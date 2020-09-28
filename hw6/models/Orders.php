
<?php

namespace app\models;

class Good extends Model
{
    public $id;
    public $goods;
    public $status;
    public $info;

    protected function getTableName()
    {
        return 'orders';
    }
};
