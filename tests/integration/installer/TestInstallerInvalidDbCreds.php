<?php

class TestInstallerInvalidDbCreds extends PHPUnit_Extensions_Selenium2TestCase
{
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
        $this->url('http://localhost');
        $this->assertEquals($this->title(),'PyroCMS Installer');
        $this->byId("next_step")->click();
        $this->byId('username')->value('Test');
        $this->byId('password')->value('test');
        $this->byId('http_server')->value('apache_w');
        $this->byId('next_step')->click();
        $error = $this->byClassName('error');
        $this->assertContains('Problem connecting to the database:',$error->text());
    }
}