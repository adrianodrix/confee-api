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
    }

    protected function registerV1Routes()
    {
        $this->router->group(['prefix' => 'v1'], function() {
           $this->registerDefaultRoutes();
        });
    }

    protected function userRoutes()
    {
        $this->router->get('/', function() {
            return ['api' => 'v1'];
        });

        $this->router->get('user', function (Request $request) {
            return $request->user();
        })->middleware('auth:api');
    }
}