<?php

namespace app\assets;

class MeterAsset extends AppAsset {
    
    public $sourcePath = '@app/assets/meter';
    public $js = [
        'js/meter.js'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];
    public $css = [
        'css/meter.css'
    ];
}
