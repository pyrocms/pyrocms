<?php

//require
require_once '../../../autoload.php';
require_once 'config.php';
require_once 'PHPUnit/Framework/TestCase.php';

use \TijsVerkoyen\Akismet;

/**
 * Akismet test case.
 */
class AkismetTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Akismet
     */
    private $akismet;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        // call parent
        parent::setUp();

        // create instance
        $this->akismet = new Akismet(APIKEY, URL);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // unset instance
        $this->akismet =null;

        // call parent
        parent::tearDown();
    }

    /**
     * Tests Akismet->isSpam()
     */
    public function testIsSpam()
    {
        // no spam
        $this->assertFalse($this->akismet->isSpam(
            'No spam', 'Tijs Verkoyen', 'tijs@verkoyen.eu',
            'http://blog.verkoyen.eu',
            'http://blog.verkoyen.eu/blog/p/detail/bit-ly-php-wrapper-class',
            'comment'
        ));

        // spam
        $this->assertTrue($this->akismet->isSpam(
            'spam', 'viagra-test-123', 'spam@spam.om'
        ));
    }

    /**
     * Tests Akismet->submitHam()
     */
    public function testSubmitHam()
    {
        // submit ham
        $this->assertTrue($this->akismet->submitHam(
            '84.194.176.71', 'userAgent', 'content', 'Tijs Verkoyen',
            'akismet@verkoyen.eu'
        ));
    }

    /**
     * Tests Akismet->submitSpam()
     */
    public function testSubmitSpam()
    {
        // submit spam
        $this->assertTrue($this->akismet->submitSpam(
            '84.194.176.32', 'userAgent', 'spam', 'spam', 'spam@spam.com'
        ));
    }

    /**
     * Tests Akismet->verifyKey()
     */
    public function testVerifyKey()
    {
        // with valid key
        $this->assertTrue($this->akismet->verifyKey());

        // with invalid key
        $this->akismet = new Akismet('invalid', 'invalid');
        $this->assertFalse($this->akismet->verifyKey());
    }
}
