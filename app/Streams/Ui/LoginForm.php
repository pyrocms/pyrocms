<?php

namespace App\Streams\Ui;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Streams\Core\Support\Facades\Messages;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Form;

class LoginForm extends Form
{
    public array $fields = [
        [
            'handle' => 'email',
            'type' => 'string',
            'config' => [
                'type' => 'email',
            ],
            'required' => true,
            'input' => [
                'placeholder' => 'email@login.com',
            ],
        ],
        [
            'handle' => 'password',
            'type' => 'string',
            'required' => true,
            'config' => [
                'type' => 'password',
            ],
            'input' => [
                'placeholder' => '********',
            ],
        ]
    ];

    public array $buttons = [
        'button.login' => [
            'handle' => 'login',
            'text' => 'Login',
            'tag' => 'button',
            'type' => 'submit',
        ]
    ];

    public function handle()
    {
        if (!$this->errors) {
            return;
        }

        if (!$user = Streams::repository('users')->findBy('email', $this->values->get('email'))) {

            Messages::error('This is the error message.');
    
            $this->response = Redirect::back();

            return;
        }

        if (!Auth::guard('streams')->attempt([
            'email' => $this->values->get('email'),
            'password' => $this->values->get('password'),
        ])) {

            Messages::error('This is the error message.');
    
            $this->response = Redirect::back();

            return;
        }

        Auth::guard('streams')->login($user);

        $this->response = Redirect::to('cp');
    }
}
