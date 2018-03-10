<?php

class PolygonCest {

    public function openPolygon(\FunctionalTester $I) {
        $I->amOnPage(['/polygon/377886959']);
        $I->see('Карусель', 'h1');
    }

    public function openSchool(\FunctionalTester $I) {
        $I->amOnPage(['/polygon/195983683']);
        $I->see('Гимназия', 'h1');
    }

    public function openMall(\FunctionalTester $I) {
        $I->amOnPage(['/polygon/383314035']);
        $I->seeInSource('Торговый центр &quot;Семейный&quot;');
    }

    public function openWithOpeningHours(\FunctionalTester $I) {
        $I->amOnPage(['/polygon/139218914']);
        $I->seeElement('div', [
            'itemprop' => 'openingHours',
            'datetime' => 'Mo-Fr 09:00-19:00; Sa 10:00-18:00; Su 11:00-17:00',
        ]);
        $I->seeInSource('<title>Торговый центр &quot;Чао&quot; улица Карла Маркса, 83 справочник и организации города Нытва Пермский край</title>');
    }
    
    public function openWithSeason(\FunctionalTester $I) {
        $I->amOnPage(['/polygon/89829412']);
        $I->seeLink('Каток');
    }

}
