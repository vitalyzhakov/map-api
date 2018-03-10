<?php

namespace app\models\traits;

trait OpeningHours {

    public function openingHours() {
        $replace = [
            'Mo-Su' => 'Ежедневно',
            'Mo' => 'Понедельник',
            'Tu' => 'Вторник',
            'We' => 'Среда',
            'Th' => 'Четверг',
            'Fr' => 'Пятница',
            'Sa' => 'Суббота',
            'Su' => 'Воскресенье',
            'off' => 'выходной',
        ];
        $oh = $this->openingHours;

        foreach ($replace as $key => $value) {
            $oh = str_replace($key, $value, $oh);
        }
        return $oh;
    }

}
