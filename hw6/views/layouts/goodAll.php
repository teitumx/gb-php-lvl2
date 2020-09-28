<?php

/**
 * @var \app\models\Good[] $goods
 */
?>
<?php foreach ($goods as $good) : ?>
    <h2><?= $good->name ?></h2>
    <h3><?= $good->price ?></h3>
    <h4><?= $good->info ?></h4>
    <a href="?c=user&a=one&id=<?= $good->id ?>">Подробнее</a>
    <hr>
<?php endforeach; ?>