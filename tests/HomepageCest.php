<?php

class HomepageCest 
{    
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    public function hasPageTitle(AcceptanceTester $I)
    {
        $I->see('Homepage');
    }
    
    public function vueIsRendered(AcceptanceTester $I)
    {
        $I->see('You\'re viewing the <HelloWorld> component!');
    }       
}