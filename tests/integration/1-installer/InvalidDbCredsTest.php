<?php

use Goutte\Client;

class InvalidDbCredsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group all
     * @group installer
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

        // Try submitting crappy details
        $form = $crawler->filter('#next_step')->form();
        $crawler = $this->client->submit($form, array(
            'http_server' => 'apache_wo',
            'db_driver' => PYRO_DB_DRIVER,
            'hostname' => 'fake-domain',
            'username' => 'test',
            'password' => 'test',
            'port' => '3306',
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

        // Try submitting crappy details
        $form = $crawler->filter('#next_step')->form();

        $payload = array(
            'http_server' => 'apache_wo',
            'db_driver' => PYRO_DB_DRIVER,
        );

        switch (PYRO_DB_DRIVER)
        {
            case 'mysql':
            case 'pgsql':
                $payload['hostname']  = PYRO_DB_HOST;
                $payload['port']      = PYRO_DB_PORT;
                $payload['username']  = PYRO_DB_USER;
                $payload['password']  = PYRO_DB_PASS;
            
                $expectedError = 'The Database Name field is required';
                break;

            case 'sqlite':
                $payload['location']  = '';

                $expectedError = 'The location field is required.';
                break;

            default:
                throw new Exception('Invalid PYRO_DB_DRIVER');
        }

        $crawler = $this->client->submit($form, $payload);
        $this->assertContains($expectedError, $crawler->filter('.error')->text());
    }
}
