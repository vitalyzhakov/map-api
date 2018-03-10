<?php
/* @var $model \app\models\Meter */
?>
<p>Добрый день!</p>
<p>Отправляем Вам данные счётчиков.</p>
<p>Адрес: <b><?= $model->address ?></b></p>
<p>Клиент: <b><?= $model->fio ?></b></p>
<p>Холодная вода: <b><?= $model->cold_water ?> куб. м.;</b></p>
<?php if ($model->hot_water): ?>
    <p>Горячая вода: <b><?= $model->hot_water; ?> куб. м.</b></p>
<?php endif; ?>
<?php if ($model->electricity_status == $model::ELECTRICITY_TYPE_VALUE_ONE_PHASE): ?>
    <p>
        Имеется <b>однотарифный</b> счётчик электричества, его показания:
        <b><?= $model->electricity_day; ?></b> КВт.
    </p>
<?php elseif ($model->electricity_status == $model::ELECTRICITY_TYPE_VALUE_TWO_PHASES): ?>
    <p>
        Имеется <b>двухтарифный</b> счётчик электричества, его показания:
        <b><?= $model->electricity_day; ?></b> КВт (день),
        <b><?= $model->electricity_night; ?></b> КВт (ночь).
    </p>
<?php endif; ?>
<p>Дата отправки: <?= date('d.m.Y'); ?>.</p>