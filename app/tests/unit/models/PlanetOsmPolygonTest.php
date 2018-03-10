<?php

namespace tests\models;

use app\models\PlanetOsmPolygon;

class PlanetOsmPolygonTest extends \Codeception\Test\Unit
{

    public function testGetAddress()
    {
        $model = new PlanetOsmPolygon();
        expect($model->getAddress())->equals('');
        
        $model->addrStreet = 'улица Будённого';
        expect($model->getAddress())->equals('улица Будённого');
        
        $model->addrHousenumber = '9а';
        expect($model->getAddress())->equals('улица Будённого, 9а');
    }
}
