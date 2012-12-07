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
        $this->url('/');
        $this->assertEquals($this->title(),'PyroCMS Installer');
        $this->byId("next_step")->click();
        $this->byId('username')->value('Test');
        $this->byId('password')->value('test');
        $this->byId('http_server')->value('apache_w');
        $this->byClassName('btn')->click();
        $this->assertContains('installer/step_1',$this->url());
    }
}