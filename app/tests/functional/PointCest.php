<?php


class PointCest
{

    public function openPoint(\FunctionalTester $I)
    {
        $I->amOnPage(['/point/3873212641']);
        $I->see('ТеплОкна', 'h1');
        $I->seeElement('meta', [
            'itemprop' => 'latitude',
            'content' => '57.938227',
        ]);

        $I->seeElement('meta', [
            'itemprop' => 'longitude',
            'content' => '55.330315',
        ]);

        $I->seeLink('Посмотреть на карте', '/center/57.938227,55.330315/zoom/16/clk/57.938227,55.330315');
    }
    
    public function notFoundPoint(\FunctionalTester $I) {
        $I->amOnPage(['/point/123123']);
        $I->seePageNotFound();
    }

}

