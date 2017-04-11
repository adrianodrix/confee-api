<?php

namespace Confee\Units\Authentication\Http\Routes;

use Confee\Support\Http\Routing\RouteFile;
use Illuminate\Http\Request;

class Api extends RouteFile
{

    /**
     * Config Routes
     *
     * @return mixed
     */
    protected function routes()
    {
        $this->registerDefaultRoutes();
        $this->registerV1Routes();
    }

    protected function registerDefaultRoutes()
    {
        $this->userRoutes();
        $this->loginRoutes();
        $this->signUpRoutes();
        $this->passwordsRoutes();
    }

    protected function registerV1Routes()
    {
        $this->router->group(['prefix' => 'v1'], function() {
           $this->registerDefaultRoutes();
        });
    }

    protected function userRoutes()
    {
        $this->router->get('user', function (Request $request) {
            return $request->user();
        })->middleware('auth:api');
    }

    protected function loginRoutes()
    {
        $this->router->post('login', 'LoginController@login');
    }

    protected function signUpRoutes()
    {
        $this->router->post('register', 'RegisterController@register');
    }

    protected function passwordsRoutes()
    {
        $this->router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
        $this->router->post('password/reset', 'ResetPasswordController@reset');
    }
}