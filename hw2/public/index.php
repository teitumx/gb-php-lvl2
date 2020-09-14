<?php

// include dirname(__DIR__) . '/services/Autoload.php';

// spl_autoload_register([(new Autoload()), 'myautoload']);

spl_autoload_register(function ($class) {
    require __DIR__ . './' . str_replace('\\', '/', $class) . '.php';
});




// $user = new app\User();
// var_dump($user);

$good = new models\Good($db);
$db = new services\DB();
echo $good->getOne('12');
echo '<hr>';
echo $good->getAll('12');

// function __autoload($name)
// {
//     (new Autoload())->load($name);
// }
