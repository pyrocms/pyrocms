<?php

use Goutte\Client;

class InvalidDbCredsTest extends PHPUnit_Framework_Testcase
{
    /**
     * @group installer
     * @group all
     */
    public function setUp()
    {
        $this->client = new Client();
        $this->client->followRedirects(true);
    }

    public function tearDown()
    {
        unset($this->client);
    }
    /**
     * Given a fresh Pyro install
     * When a user provides invalid db credentials
     * Then the install should error and halt
     */
    public function testInstallWithInvalidDBCredentials()
    {
        // Check that loading root redirects to installer
        $crawler = $this->client->request('GET', 'http://'.PYRO_WEB_HOST);
        $this->assertEquals($crawler->filter('title')->text(), 'PyroCMS Installer');

        $link = $crawler->selectLink('Step #1')->link();
        $crawler = $this->client->click($link);

        // Try submitting crappy details
        $form = $crawler->filter('#next_step')->form();
        $crawler = $this->client->submit($form, array(
            'http_server' => 'apache_wo',
            'hostname' => 'fake-domain',
            'username' => 'test',
            'password' => 'test',
            'database' => 'nope',
        ));
        $this->assertContains('Problem connecting to', $crawler->filter('.error')->text());
    }

    /**
     * Given that the database field is not provided
     * When the form is submitted
     * Then an error should display on the same page
     */
    public function testInstallWithMissingDB()
    {
        // Check that loading root redirects to installer
        $crawler = $this->client->request('GET', 'http://'.PYRO_WEB_HOST);
        $this->assertEquals($crawler->filter('title')->text(), 'PyroCMS Installer');

        $link = $crawler->selectLink('Step #1')->link();
        $crawler = $this->client->click($link);
        
        // Try submitting crappy details
        $form = $crawler->filter('#next_step')->form();
        $crawler = $this->client->submit($form, array(
            'http_server' => 'apache_wo',
            'hostname'  => PYRO_DB_HOST,
            'port'      => PYRO_DB_PORT,
            'username'  => PYRO_DB_USER,
            'password'  => PYRO_DB_PASS,
        ));
        $this->assertContains('The MySQL Database field is required', $crawler->filter('.error')->text());
    }


}
