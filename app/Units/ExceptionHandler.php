<?php

namespace Confee\Units;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Response;
use Symfony\Component\Debug\Exception\FlattenException;

class ExceptionHandler extends Handler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }

    /**
     * Create a response for the given exception.
     *
     * @param  \Exception  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        // Define the response Exception
        $e = FlattenException::create($e);

        // Grab the HTTP status code from the Exception
        $statusCode = $e->getStatusCode();

        // Grab the HTTP status text from the Status Code
        $statusText = Response::$statusTexts[$statusCode];


        // Define the response
        $response = [
            'message' => 'Sorry, something went wrong.'
        ];

        // If the app is in debug mode
        if (config('app.debug')) {
            $response['message'] = ($e->getMessage() == '') ? $statusText : $e->getMessage();
            $response['exception'] = $e->getClass();
            $response['file'] = $e->getFile();
            $response['line'] = $e->getLine();
        } else {
            $response['message'] = $statusText;
        }

        // Return a JSON response with the response array and status code
        return response()->json($response, $statusCode);
    }
}
