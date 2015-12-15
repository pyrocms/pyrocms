<?php

namespace App\Providers;

use Anomaly\PaymentsModule\Payment\PaymentProcessor;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\PayPal\ExpressGateway;
use Omnipay\PayPal\Message\ExpressAuthorizeResponse;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(
            ['namespace' => $this->namespace],
            function ($router) {
                require app_path('Http/routes.php');
            }
        );

        $router->any(
            'paypal',
            function (PaymentProcessor $processor) {

                $parameters = [
                    'gateway'   => 'anomaly.extension.paypal_express_gateway',
                    'amount'    => 50.00,
                    'currency'  => 'usd',
                    'cancelUrl' => 'http://workbench.local:8888/poop',
                    'returnUrl' => 'http://workbench.local:8888/success'
                ];

                /* @var RedirectResponseInterface $response */
                $response = $processor->purchase($parameters);

                $response->redirect();
            }
        );

        $router->any(
            'success',
            function (PaymentProcessor $processor) {

                $parameters = [
                    'gateway'   => 'anomaly.extension.paypal_express_gateway',
                    'amount'    => 50.00,
                    'currency'  => 'usd',
                    'cancelUrl' => 'http://workbench.local:8888/success',
                    'returnUrl' => 'http://workbench.local:8888/paypal'
                ];

                /* @var RedirectResponseInterface $response */
                $response = $processor->purchase($parameters);

                dd($response->getData());
            }
        );
    }
}
