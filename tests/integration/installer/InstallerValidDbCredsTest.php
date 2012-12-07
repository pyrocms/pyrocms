<?php

class TestInstallerValidDbCreds extends PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * @group installer
     * @group all
     */
    public function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://localhost');
    }

    public function tearDown()
    {
    }

    /**
     * @test
     * Given a fresh Pyro install
     * When a user provides valid db auth credentials
     * Then the install should authenticate that db user and continue
     */
    public function DatabaseAuthenticationWithValidCreds()
    {
        $this->url('/installer');
        $this->assertEquals($this->title(),'PyroCMS Installer');
        $this->byId("next_step")->click();
        sleep(4);
        $this->byId("hostname")->clear();
        $this->byId("hostname")->value("127.0.0.1");
        $this->byId('username')->value('pyro');
        $this->byId('password')->value('pyro');
        $this->byId('next_step')->click();
        $this->assertContains('installer/step_4',$this->url());
    }
}