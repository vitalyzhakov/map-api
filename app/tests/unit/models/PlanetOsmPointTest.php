<?php

namespace tests\models;

use app\models\PlanetOsmPoint;

class PlanetOsmPointTest extends \Codeception\Test\Unit
{

    public function testAddrSuffix()
    {
        $model = new PlanetOsmPoint();
        
        $model->level = '3';
        expect($model->addrSuffix())->equals('3 этаж');
        
        $model->addrDoor = '208';
        expect($model->addrSuffix())->equals('3 этаж, офис 208');
    }
}
