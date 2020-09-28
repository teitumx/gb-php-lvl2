<?php

/** 
 * @var string $content
 * @var string $title
 * */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title ?></title>
</head>

<body>
    <ul>
        <li><a href="/">Главная</a> </li>
        <hr>
        <li><a href="?c=user&a=all">Все пользователи</a> </li>
        <li><a href="?c=user&a=one">Один пользователь</a> </li>
        <li><a href="?c=user&a=add">Добавить пользователя</a> </li>
        <hr>
        <li><a href="?c=good&a=all">Все товары</a> </li>
        <li><a href="?c=good&a=one">Один товар</a> </li>
        <li><a href="?c=good&a=add">Добавить товар</a> </li>
    </ul>
    <?= $content ?>
</body>

</html>