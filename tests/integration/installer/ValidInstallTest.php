<?php

use Goutte\Client;

class ValidInstallTest extends PHPUnit_Framework_Testcase
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
     * When a user provides valid db auth credentials
     * Then the install should authenticate that db user and continue
     */
    public function testInstallWithValidCreds()
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
            'database'  => PYRO_DB_NAME,
            'create_db' => PYRO_DB_CREATE === "1",
        ));

        // If there is an error, show it and fail. There should be 0 errors
        $errorNode = $crawler->filter('.error');
        $this->assertEquals(0, count($errorNode), count($errorNode) ? $errorNode->text() : '');

        // Made it past Step 3 and onto Step 4
        $this->assertContains('Step 4:', $crawler->filter('.title h3')->text());

        // Keep on trucking, lets finish this!
        $form = $crawler->filter('#next_step')->form();

        // submit user forms
        $crawler = $this->client->submit($form, array(
            'user_name'   => 'admin',
            'user_firstname'  => 'Pyro',
            'user_lastname'   => 'Admin',
            'user_email'      => 'admin@admin.com',
            'user_password'   => 'administrator',
        ));

        $this->assertContains('Congratulations', $crawler->html());
    }
}
