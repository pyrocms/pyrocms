<?php

require dirname(dirname(__FILE__)) . '/goutte.phar';
use Goutte\Client;

class CreateValidUserTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->client = new Client();
        $this->client->followRedirects(true);
    }

    public function tearDown()
    {
        unset($this->client);
    }

    public function navigateToStepFour()
    {
        $crawler = $this->client->request('GET', 'http://'.PYRO_HOST.'/installer');

        $link = $crawler->selectLink('Step #1')->link();
        $crawler = $this->client->click($link);
        $form = $crawler->selectButton('Step #2')->form();
        $formFields = array(
            'username'=>'pyro',
            'password'=>'pyro',
            'database'=>'pyrocms',
            'create_db'=>'true',
            'hostname' => '127.0.0.1'
        );
        $crawler = $this->client->submit($form,$formFields);

        return $crawler;
    }
    /**
     * @test
     * Given that the database settings are successful
     * When the user form is filled out
     * Then the user should be created and user taken to confirmation page
     */
    public function CreateAdminUserInInstaller()
    {
        $crawler = $this->navigateToStepFour();
        $form = $crawler->selectButton('Install')->form();
        $formFields = array(
            'user_name'=>'admin',
            'user_firstname'=> 'Pyro',
            'user_lastname' => 'Admin',
            'user_email' => 'admin@admin.com',
            'user_password' => 'administrator'
        );
        //submit user forms
        $crawler = $this->client->submit($form,$formFields);
    }
}