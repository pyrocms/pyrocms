<?php

namespace App\Providers;

use App\Streams\Ui\LoginForm;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\ServiceProvider;

class StreamsServiceProvider extends ServiceProvider
{
    public function register()
    {
        UI::register('form.login', LoginForm::class);
    }

    public function boot()
    {
        //
    }
}
