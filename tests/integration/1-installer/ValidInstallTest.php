<?php

use Goutte\Client;

class ValidInstallTest extends PHPUnit_Framework_TestCase
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
     * When a user provides valid db auth credentials
     * Then the install should authenticate that db user and continue
     */
    public function testInstallWithValidCreds()
    {
        // Check that loading root redirects to installer
        $crawler = $this->client->request('GET', 'http://'.PYRO_WEB_HOST);
        $this->assertEquals($crawler->filter('title')->text(), 'PyroCMS Installer');

        $payload = array(
            'http_server' => 'apache_wo',
            'db_driver' => PYRO_DB_DRIVER,
            'create_db' => PYRO_DB_CREATE === "1",
        );

        switch (PYRO_DB_DRIVER)
        {
            case 'mysql':
            case 'pgsql':
                $payload['hostname']  = PYRO_DB_HOST;
                $payload['port']      = PYRO_DB_PORT;
                $payload['database']  = PYRO_DB_NAME;
                $payload['username']  = PYRO_DB_USER;
                $payload['password']  = PYRO_DB_PASS;
                break;

            case 'sqlite':
                $payload['location']  = PYRO_DB_LOCATION;
                $payload['password']  = PYRO_DB_PASS;
                break;
        }

        // Try submitting crappy details
        $form = $crawler->filter('#next_step')->form();
        $crawler = $this->client->submit($form, $payload);

        // If there is an error, show it and fail. There should be 0 errors
        $errorNode = $crawler->filter('.error');
        $this->assertEquals(0, count($errorNode), count($errorNode) ? 'Unexpected install error: '.$errorNode->text() : '');

        // Made it past Step 3 and onto Step 4
        $this->assertContains('Step 4:', $crawler->filter('.title h3')->text());

        // Keep on trucking, lets finish this!
        $form = $crawler->filter('#next_step')->form();

        // submit user forms
        $crawler = $this->client->submit($form, array(
            'user_username'   => 'admin',
            'user_firstname'  => 'Pyro',
            'user_lastname'   => 'Admin',
            'user_email'      => 'admin@admin.com',
            'user_password'   => 'administrator',
        ));

        $this->assertContains('Congratulations', $crawler->html());
    }
}
