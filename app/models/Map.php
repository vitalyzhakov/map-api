<?php namespace app\models;

class Map extends \yii\base\Model
{

    /**
     * Координаты центра
     * 
     * @var type 
     */
    public $latlng;

    /**
     * Текущий zoom
     * 
     * @var type 
     */
    public $zoom;

    /**
     * Координаты клика
     * @var type 
     */
    public $clatlng;

    public function init()
    {
        $mapDefault = \Yii::$app->params['mapDefault'];
        $this->latlng = $mapDefault['latlng'];
        $this->zoom = $mapDefault['zoom'];

        return parent::init();
    }

    /**
     * Заполняет настройки карты клиентскими параметрами
     * 
     * @param type $lat
     * @param type $lng
     * @param type $zoom
     * @param type $clat
     * @param type $clng
     */
    public function initFromGet($lat, $lng, $zoom, $clat, $clng)
    {
        if ($lng !== null && $lat !== null) {
            $this->latlng = [
                floatval($lat), floatval($lng)
            ];
        }

        if ($zoom !== null) {
            $this->zoom = intval($zoom);
        }

        if ($clat !== null && $clng !== null) {
            $this->clatlng = [
                'lat' => floatval($clat),
                'lng' => floatval($clng)
            ];
        }
    }
}
