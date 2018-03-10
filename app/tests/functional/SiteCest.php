<?php


class SiteCest
{

    public function openXmlSiteMap(\FunctionalTester $I)
    {
        $I->amOnPage(['/sitemap.xml']);
        $I->seeInSource('<url><loc>https://vnytve.ru/polygon/377886959</loc></url>');        
    }

}
                
