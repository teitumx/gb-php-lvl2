<?php

use app\services\Autoload;
use app\models\Good;

include dirname(__DIR__) . '/services/Autoload.php';
spl_autoload_register([(new Autoload()), 'load']);


$good = new Good();


$goodModel = $good->getOne('1');
var_dump($goodModel);
echo '<hr>';
var_dump($good->getAll());

$good->id = 8;
$good->name = 'Lamp';
$good->price = '500';
$good->info = 'Info about Lamp';
$good->save();
