<?php

use app\services\Request;

include dirname(__DIR__) . '/vendor/autoload.php';
$config = include dirname(__DIR__) . '/main/config.php';

\app\main\App::call()->run($config);
