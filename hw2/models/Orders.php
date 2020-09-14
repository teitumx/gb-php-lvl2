
<?php

namespace models\Orders;

class Good extends Model
{
    public $id;
    public $goods;
    public $status;
    public $info;

    protected function getTableName(): string
    {
        return 'orders';
    }
};
