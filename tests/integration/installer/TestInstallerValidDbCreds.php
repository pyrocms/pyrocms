<?php

class TestInstallerValidDbCreds extends PHPUnit_Extensions_Selenium2TestCase
{
    public function setUp()
    {
        $this->setBrowser('firefox*');
        $this->setBrowserUrl('http://127.0.0.1');
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
        $this->byId("hostname")->value("127.0.0.1");
        $this->byId('username')->value('root');
        $this->byId('password')->value('');
        $this->byId('post')->value('3306');
        $this->byId('http_server')->value('apache_w');
        $this->byId('next_step')->click();
        $this->assertNotContains('Problem connecting to the database:',$this->byId('container')->text());
    }
}