<?php

use app\services\Request;

include dirname(__DIR__) . '/vendor/autoload.php';

$controllerName = 'user';
$request = new Request;
if (!empty($request->getActionName())) {
    $controllerName = $request->getControllerName();
}

// include dirname(__DIR__) . '/services/Autoload.php';
// spl_autoload_register([(new Autoload()), 'load']);


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



$controllerClass = 'app\\controllers\\' . ucfirst($controllerName) . 'Controller';

if (class_exists($controllerClass)) {
    $renderer = new \app\services\RenderTwigServices();
    $controller = new $controllerClass($renderer, $request);
    echo $controller->run($request->getActionName());
} else {
    echo '404';
}
