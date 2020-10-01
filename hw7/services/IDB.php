<?php
namespace app\services;

interface IDB 
{
    public function find($sql, $params);
    public function findAll($sql);
}