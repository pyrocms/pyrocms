<?php

namespace App\Streams\Ui;

use Illuminate\Support\Facades\Redirect;
use Streams\Core\Support\Facades\Messages;
use Streams\Ui\Components\Form;

class LoginForm extends Form
{
    public $fields = [
        [
            'handle' => 'email',
            'type' => 'string',
            'config' => [
                'type' => 'email',
            ],
            'required' => true,
        ],
        [
            'handle' => 'password',
            'type' => 'string',
            'required' => true,
            'config' => [
                'type' => 'password',
            ],
        ]
    ];

    public function handle()
    {
        if (!$this->errors) {
            return;
        }

        Messages::error('This is the error message.');

        $this->response = Redirect::back();
    }
}
