<?php namespace Tests\Unit;

use Illuminate\Contracts\Console\Kernel;
use Tests\TestCase;

/**
 * Class BootstrapTest
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BootstrapTest extends TestCase
{

    /**
     * Make sure the application
     * was created as it should.
     */
    public function testCreatesApplication()
    {
        $this->assertInstanceOf(\Illuminate\Contracts\Foundation\Application::class, $this->createApplication());
    }

    /**
     * Make sure the console kernel
     * is from the Streams Platform.
     */
    public function testCreatesConsoleKernel()
    {
        $this->assertInstanceOf(\Anomaly\Streams\Platform\Console\Kernel::class, $this->app[Kernel::class]);
    }
}
