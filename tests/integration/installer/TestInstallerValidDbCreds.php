<?php

class TestInstallerValidDbCreds extends PHPUnit_Extensions_Selenium2TestCase
{
    public function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://localhost:8099');
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
        $this->url('http://localhost:8099');
        $this->assertEquals($this->title(),'PyroCMS Installer');
        $this->byId("next_step")->click();
        $this->byId('username')->value('pyro');
        $this->byId('password')->value('pyro');
        $this->byId('http_server')->value('apache_w');
        $this->byId('next_step')->click();
        $this->assertNotContains('Problem connecting to the database:',$this->byId('container')->text());
    }
}