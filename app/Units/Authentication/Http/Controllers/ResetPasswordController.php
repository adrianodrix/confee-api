<?php

namespace Confee\Units\Authentication\Http\Controllers;

use Confee\Support\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        if ($response === Password::PASSWORD_RESET) {
            try {
                // get user
                $user = $this->guard()->user();

                // attempt to verify the credentials and create a token for the user
                $token = app('tymon.jwt.auth')->fromUser($user);
            } catch (\Exception $e) {
                throw new \Exception(trans('passwords.token'));
            }

            return response()->json([
                'status' => trans($response),
                'token' => $token
            ], Response::HTTP_OK);
        }

        // If an error was returned by the password broker, we will get this message
        // translated so we can notify a user of the problem. We'll redirect back
        // to where the users came from so they can attempt this process again.
        return response()->json([
            'error' => trans($response)
        ], Response::HTTP_FORBIDDEN);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only(
            'email', 'password', 'token'
        );

        return array_merge($credentials, [
            'password_confirmation' => $credentials['password']
        ]);
    }
}
