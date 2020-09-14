<?php

interface IDB 
{
    public function find($sql);
    public function findAll($sql);
}