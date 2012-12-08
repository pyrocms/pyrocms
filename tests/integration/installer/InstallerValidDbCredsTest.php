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
        //exec('sudo chmod -R 777 ../../../*');
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
        $this->assertContains('installer/step_1',$this->url());
        $this->byId("hostname")->clear();
        $this->byId("database")->value('pyrocms');
        $this->byId("create_db")->click();
        $this->byId("hostname")->value("127.0.0.1");
        $this->byId('username')->value('pyro');
        $this->byId('password')->value('pyro');
        $this->byClassName('btn')->click();
        $this->assertContains('installer/step_4',$this->url());
    }

    /**
     * @test
     * Given that valid credentials are provided and the filesystem isn't writable
     * When the form to setup the db is submitted
     * Then the page should navigate to installer/step_3
     */

    public function FileSystemNotWritable()
    {
        exec('sudo chmod -R 555 ../../../*');
        $this->url('/installer');
        $this->byId('next_step')->click();
        $this->byId('hostname')->clear();
        $this->byId('database')->value('pyrocms');
        $this->byId('create_db')->click();
        $this->byId('hostname')->value('127.0.0.1');
        $this->byId('username')->value('pyro');
        $this->byId('password')->value('pyro');
        $this->byClassName('btn')->click();
        $this->assertContains('installer/step_3',$this->url());
    }
}
