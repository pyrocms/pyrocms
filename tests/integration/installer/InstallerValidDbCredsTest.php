<?php

require dirname(dirname(__FILE__)) . '/goutte.phar';
use Goutte\Client;

class TestInstallerValidDbCreds extends PHPUnit_Framework_TestCase
{
    /**
     * @group installer
     * @group all
     */
    public function setUp()
    {
        $this->client = new Client();
    }

    public function tearDown()
    {
        unset($this->client);
    }

    /**
     * @test
     * Given a fresh Pyro install
     * When a user provides valid db auth credentials
     * Then the install should authenticate that db user and continue
     */
    public function DatabaseAuthenticationWithValidCreds()
    {
        $formFields = array(
            'hostname'=>'127.0.0.1',
            'username'=>'pyro',
            'password'=>'pyro',
            'create_db'=>'true',
            'database'=>'pyrocms'
        );
        $crawler = $this->client->request('GET','http://localhost/');
        $this->assertEquals($crawler->filter('title')->text(),'PyroCMS Installer');
        $link = $crawler->selectLink('Step #1')->link();
        $crawler = $this->client->click($link);
        $form = $crawler->selectButton('Step #2')->form();
        $crawler = $this->client->submit($form,$formFields);
        $this->assertContains('Step 4:',$crawler->filter('.title h3')->text());
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
        $formFields = array(
            'hostname'=>'127.0.0.1',
            'username'=>'pyro',
            'password'=>'pyro',
            'create_db'=>'true',
            'database'=>'pyrocms'
        );
        $crawler = $this->client->request('GET','http://localhost/');
        $this->assertEquals($crawler->filter('title')->text(),'PyroCMS Installer');
        $link = $crawler->selectLink('Step #1')->link();
        $crawler = $this->client->click($link);
        $form = $crawler->selectButton('Step #2')->form();
        $crawler = $this->client->submit($form,$formFields);
        $this->assertContains('Step 3:',$crawler->filter('.title h3')->text());
        exec('sudo chmod -R 777 ../../../*');
    }
}
