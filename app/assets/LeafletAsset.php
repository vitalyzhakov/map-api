<?php

namespace app\assets;

use yii\web\AssetBundle;

class LeafletAsset extends AssetBundle {

    public $sourcePath = '@bower/leaflet/dist';
    public $css = [
        'leaflet.css'
    ];
    public $js = [
        'leaflet.js',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END,
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
