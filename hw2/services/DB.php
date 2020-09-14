<?php

namespace services\DB;

class DB implements IDB
{
    public function find($sql)
    {
        return 'find ' . $sql;
    }

    public function findAll($sql)
    {
        return 'find All ' . $sql;
    }
}
