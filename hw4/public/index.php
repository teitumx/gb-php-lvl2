<?php

use app\services\Autoload;

include dirname(__DIR__) . '/services/Autoload.php';
spl_autoload_register([(new Autoload()), 'load']);


// $good = new Good();

// $goodModel = Good::getOne('1');
// var_dump($goodModel);
// echo '<hr>';
// var_dump(Good::getAll());

// //$good->id = 8;
// $good->name = 'Lamp1';
// $good->price = '500';
// $good->info = 'Info about Lamp';
// $good->save();

// var_dump($good);

$controllerName = 'user';
if (!empty(trim($_GET['c']))) {
    $controllerName = trim($_GET['c']);
}

$actionName = '';
if (!empty(trim($_GET['a']))) {
    $actionName = trim($_GET['a']);
}

$controllerClass = 'app\\controllers\\' . ucfirst($controllerName) . 'Controller';

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    echo $controller->run($actionName);
} else {
    echo '404';
}

var_dump($controller);
