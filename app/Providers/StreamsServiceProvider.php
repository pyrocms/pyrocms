<?php

namespace App\Providers;

use App\Streams\Ui\LoginForm;
use App\Streams\Ui\FilesTable;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\ServiceProvider;

class StreamsServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        UI::component('form.login', LoginForm::class);
        UI::component('files.table', FilesTable::class);
    }
}
