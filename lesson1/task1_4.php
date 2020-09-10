<?php

class Deliver
{
    public $id = '';
    public $status = '';
    public $size = '';
    public $deliverDate = '';
    public $adress = '';
    public $packed = false;

    public function __construct($id, $status, $size, $deliverDate, $adress, $packed)
    {
        $this->id = $id;
        $this->status = $status;
        $this->size = $size;
        $this->deliverDate = $deliverDate;
        $this->adress = $adress;
        $this->packed = $packed;
    }

    public function displayInfo()
    {
        echo <<<php
        <h3>$this->id</h3>
        <p>$this->status</p>
        <p>$this->deliverDate</p>

php;
    }

    public function packaging()
    {
        $this->packed = true;
    }
}

class Letter extends Deliver
{
    public $cover;

    public function __construct($id, $status, $size, $deliverDate, $adress, $cover, $packed)
    {
        $this->cover = $cover;
        parent::__construct($id, $status, $size, $deliverDate, $adress, $packed);
    }

    public function expressDeliver($newDate)
    {
        $this->deliverDate = $newDate;
    }
}
