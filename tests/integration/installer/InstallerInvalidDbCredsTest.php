<?php

class TestInstallerInvalidDbCreds extends PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * @group installer
     * @group all
     */
    public function setUp()
    {
        $this->setBrowserUrl('http://localhost');
        $this->setBrowser('firefox');

    }

    /**
     * @test
     * Given a fresh Pyro install
     * When a user provides invalid db credentials
     * Then the install should error and halt
     */
    public function InstallWithInvalidDBCredentials()
    {
        $this->using('shared');
        $this->url('/installer');
        $this->assertEquals($this->title(),'PyroCMS Installer');
        $this->byId("next_step")->click();
        $this->byId('username')->value('Test');
        $this->byId('password')->value('test');
        $this->byId('http_server')->value('apache_w');
        $this->byClassName('btn')->click();
        $this->assertContains('installer/step_1',$this->url());
    }

    /**
     * @test
     * Given that the database field is not provided
     * When the form is submitted
     * Then an error should display on the same page
     */
     public function InstallWithMissingDB()
     {
         $this->using('shared');
         $this->url('/installer');
         $nextStep = $this->byId('next_step');
         $nextStep->click();
         unset($nextStep);
         $this->byId('username')->value('pyro');
         $this->byId('password')->value('pyro');
         $this->byClassName('btn')->click();
         $this->assertContains('The MySQL Database field is required',$this->byClassName('error')->text());
     }


}